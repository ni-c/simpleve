<?php

/**
 * API component
 * 
 * @author Willi Thiel
 * @date 2010-09-13
 * @version 1.0
 */
class AleApiComponent extends Object {

    var $controller = null;

    var $eveonline;
    var $evecentral;

    /**
     * Save reference to controller on startup.
     * 
     * @param $controller The parent controller of this component.
     */
    public function init(&$controller)
    {
        $this->controller = $controller;
        $this->eveonline = AleFactory::getEVEOnline();
        $this->evecentral = AleFactory::getEVECentral();
    }
    
    public function getCharacterSheets($Apis) {
        $result = array();
        foreach ($Apis as $Api) {
            if (($Api['Api']['is_active'] == 1) && ($Api['Api']['errorcode']<200)) {
                $this->eveonline->setCredentials($Api['Api']['api_user_id'], $Api['Api']['api_key']);
                $result[$Api['Api']['id']] = $this->_getCharacters($Api);
           }
        }
        return $result;
    }    
    
    public function getCorporations($Apis) {
        $result = array();
        foreach ($Apis as $Api) {
            if (($Api['Api']['is_active'] == 1) && ($Api['Api']['errorcode']<200)) {
                $this->eveonline->setCredentials($Api['Api']['api_user_id'], $Api['Api']['api_key']);
                $characters = $this->convertToArray($this->_getCharacters($Api));
                foreach ($characters as $character) {
                    if (!isset($result[$character['corporationID']])) {
                        $result[$character['corporationID']]['corporationSheet'] = $this->requestApi('corp', 'CorporationSheet', array('corporationID' => $character['corporationID']))->getSimpleXMLElement()->result;
                        if (($result[$character['corporationID']]['corporationSheet']->logo->shape1 == 0) &&
                            ($result[$character['corporationID']]['corporationSheet']->logo->shape2 == 0) &&
                            ($result[$character['corporationID']]['corporationSheet']->logo->shape3 == 0) &&
                            ($result[$character['corporationID']]['corporationSheet']->logo->color1 == 0) &&
                            ($result[$character['corporationID']]['corporationSheet']->logo->color2 == 0) &&
                            ($result[$character['corporationID']]['corporationSheet']->logo->color3 == 0)) {
                            $result[$character['corporationID']]['npccorp'] = true;
                        } else {
                            $result[$character['corporationID']]['npccorp'] = false;
                        }
                    }
                }
            }
        }
        return $result;
    }
    
    public function requestApis($Apis, $api = 'corp', $type = 'CharacterSheet', $onlyCurrentChar = false) {
        $result = array();
        $i = 0;
        foreach ($Apis as $Api) {
            if (($Api['Api']['is_active'] == 1) && ($Api['Api']['errorcode']<200) && (!empty($Api['Api']['api_user_id'])) && (!empty($Api['Api']['api_key']))) {
                $this->eveonline->setCredentials($Api['Api']['api_user_id'], $Api['Api']['api_key']);
                try {
                    $accountCharacters = $this->_getCharacters($Api);
                } catch (AleExceptionEVEAuthentication $e) {
                    if ($e->getCode() == 203) {
                        $this->setApiStatus($Api['Api']['api_user_id'], 0, $e->getCode());
                        return $result;
                    }
                } catch (AleExceptionEVEMiscellaneous $e) {
                    $this->controller->set('APIException', $e->getMessage());
                    return array();
                    echo 'EVE API Exception: ' . $e->getMessage();
                    die();
                }
                if ($accountCharacters!==false) {
                    foreach ($accountCharacters->result->characters as $character) {

                        //set characterID for CharacterSheet
                        $this->eveonline->setCharacterID($character->characterID);
    
                        try {                    
                            if (($onlyCurrentChar==false) || ($character->characterID==$this->controller->active_character['characterID'])) {
                                $apiResult = $this->eveonline->$api->$type();
                                if ($onlyCurrentChar==false) {
                                    $result[$Api['Api']['id']][$i] = array(
                                        'api' => $apiResult->result,
                                        'type'   => $api,
                                        'characterID' => (string) $character->characterID,
                                        'corporationID' => (string) $character->corporationID
                                    );
                                    $i++;
                                } else {
                                    $result = $apiResult->result;
                                }
                            }
                            
                        } catch (AleExceptionRequest $e) {
                            // Connection error
                            
                            // Timeout
                            if ($e->getCode() == 28) {
                                /*
                                $params = array(
                                    'apiKey' => $Api['Api']['api_key'],
                                    'characterID' => $characterID,
                                    'userID' => $Api['Api']['api_user_id']
                                );
                                $this->_setCached($params, time() + 60 * 60);
                                $apiResult = $this->eveonline->$api->$type();
                                $result[$Api['Api']['id']][$characterID] = $apiResult->result;
                                 */
                            }
                        } catch (AleExceptionEVEUserInput $e) {
                            // EVE Api error (e.g. too much requests)
                            
                            // WalletTransactions cache bugfix
                            if ($type == 'WalletTransactions') {
                                $params = array(
                                    'userID' => $Api['Api']['api_user_id'], 
                                    'apiKey' => $Api['Api']['api_key'],
                                    'characterID' => $characterID
                                );
                                if ($this->isCached($params)) {
                                    $this->_setCached($params, date('Y-m-d H:i:s', time() + 45 * 60));
                                    try {                    
                                        if (($onlyCurrentChar==false) || ($character->characterID==$this->controller->active_character->characterID)) {
                                            $apiResult = $this->eveonline->$api->$type();
                                            if ($onlyCurrentChar==false) {
                                                $result[$Api['Api']['id']][$i-1]['api'] = $apiResult->result;
                                            } else {
                                                $result = $apiResult->result;
                                            }
                                        }
                                    } catch (AleExceptionEVEUserInput $e) {
                                        
                                    }
                                }
                            }
                                                        
                        } catch (AleExceptionEVEAuthentication $e) {
                            // EVEAuth error
                            
                            // Limited API
                            if ($e->getCode() == 200) {
                                $this->controller->loggedUser['limitedApi'] = true;
                            }
                        } catch (AleExceptionCache $e) {
                            
                        }
                    }
                }
            }
        }            
        return $result;
    }

    /**
     * Requests the API
     */
    public function requestApi($api, $type, $params = array(), $auth = null) {
        if ($auth == null) {
            return $this->eveonline->$api->$type($params, ALE_AUTH_NONE);
        } else {
            $this->eveonline->setCredentials($auth['api_user_id'], $auth['api_key']);
            $this->eveonline->setCharacterID($auth['api_character_id']);
            return $this->eveonline->$api->$type($params);
        }
    }

    public function getEveCentralQuicklook($id) {
        $params = array('typeid'=>array($id));
        return $this->evecentral->quicklook($params);
    }

    public function getEveCentralMarketStat($id, $region = null) {
        if (($region != null) && ((!is_numeric($region)) || ($region>11000030) || ($region<10000001))) {
            throw new Exception('Region out of range ('. $region .')!');
        }
        if ((!isset($id)) || (!is_numeric($id)) || ($id<1) || ($id>100000000000)) {
            throw new Exception('ID out of range ('. $id .')!');
        }
        
        $this->evecentral = AleFactory::getEVECentral();
        $params = array(
            'typeid'=>array($id)
        );
        if ($region != null) {
            $params['regionlimit'] = array($region);
        }
        return $this->evecentral->marketstat($params);
    }
    
    public function setApiStatus($api_user_id, $is_active, $errorcode) {
        $Api = ClassRegistry::init('Api');
        $Api->updateAll(
            array(
                'Api.is_active' => $is_active,
                'Api.errorcode' => $errorcode
            ),
            array('Api.api_user_id' => $api_user_id)
        );
    }

    public function convertToArray($apiResult) {
        $result = array();
        if (is_array($apiResult)) {
            return $apiResult;
        }
        if (isset($apiResult->getSimpleXMLElement()->result)) {
            $root = $apiResult->getSimpleXMLElement()->result->rowset->row;
        } else {
            $root = $apiResult->getSimpleXMLElement()->rowset->row;
        }
        foreach ($root as $item) {
            $dataset = array();
            $attributes = $item->attributes();
            foreach ($attributes as $attributeName => $attributeValue) {
                $attribName = trim((string)$attributeName);
                $attribVal = trim((string)$attributeValue);
                $dataset[$attribName] = $attribVal;
            }
            $result[] = $dataset;
        }
        return $result;
    }

    public function isCached($params) {
        ksort($params);
        $sha1params = sha1(http_build_query($params, '', '&'));
        $Alecache = ClassRegistry::init('Alecache');
        $cached = $Alecache->find(
                'count',
                array(
                    'conditions' => array(
                        'Alecache.params' => $sha1params,
                        'Alecache.cachedUntil >' => date('Y-m-d H:i:s') 
                    )
                ) 
            );
        return ($cached>0);   
    }

    private function _getCharacters(&$Api) {
        $result = false;
        try {
            $result = $this->eveonline->account->Characters();
            //you can traverse rowset element with attribute name="characters" as array
        } catch (AleExceptionEVEServerError $e) {
            $Api['Api']['errorcode'] = $e->getCode();
            $result[$Api['Api']['id']]['errorcode'] = $e->getCode;
            $this->controller->Api->set($Api['Api']);
            $this->controller->Api->save();
        } catch (AleExceptionRequest $e) {
            // Connection error
            return;
        } catch (AleExceptionEVEUserInput $e) {           
            // EVE Api error (e.g. too much requests)
            return;
        } catch (AleExceptionEVEAuthentication $e) {
            // API disabled
            return;
        }
        return $result;
    }
    
    private function _setCached($params, $time) {
        ksort($params);
        $sha1params = sha1(http_build_query($params, '', '&'));
        $Alecache = ClassRegistry::init('Alecache');
        $Alecache->updateAll(
            array('Alecache.cachedUntil' => "'" . $time . "'"),
            array('Alecache.params' => $sha1params)
        );
    }
    
    private function _getCached($params) {
        ksort($params);
        $sha1params = sha1(http_build_query($params, '', '&'));
        $Alecache = ClassRegistry::init('Alecache');
        $cached = $Alecache->find(
                'first',
                array(
                    'conditions' => array(
                        'Alecache.params' => $sha1params
                    )
                ) 
            );
        if ($cached===false) {
            return false;
        }
        return strtotime($cached['Alecache']['cachedUntil']);
    }
}
?>
