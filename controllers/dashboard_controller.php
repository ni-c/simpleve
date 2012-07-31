<?php

/**
 * Controller for tickets
 * 
 * @author Willi Thiel
 * @date 2010-09-12
 * @version 1.0
 */
class DashboardController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Dashboard';

    var $title_for_layout = 'Dashboard';
 
    /**
     * An array containing the class names of models this controller uses.
     *
     * - User for modifying user datasets
     * - Ticket for activation and retrievepassword eMails
     */
    var $uses = array(
        'Api',
        'EveRamActivity',
        'DashboardHiddenItem'
    );
     
    /**
     * Controller actions for which user validation is not required.
     */
    var $allowedActions = array();
    
    /**
     * Displays a static page.
     */
    function index() {
        
        $this->dashboardItems = array();
        
        $charIndustryJobs = $this->AleApi->requestApis($this->apis, 'char', 'IndustryJobs');
        $this->_parseIndustryJobs($charIndustryJobs, $this->dashboardItems);

        $charSkillQueue = $this->AleApi->requestApis($this->apis, 'char', 'SkillQueue');
        $this->_parseSkillQueue($charSkillQueue, $this->dashboardItems);

        $charMarketOrders = $this->AleApi->requestApis($this->apis, 'char', 'MarketOrders');
        $this->_parseMarketOrders($charMarketOrders, $this->dashboardItems);

        $corpIndustryJobs = $this->AleApi->requestApis($this->apis, 'corp', 'IndustryJobs');
        $this->_parseIndustryJobs($corpIndustryJobs, $this->dashboardItems);

        $corpMarketOrders = $this->AleApi->requestApis($this->apis, 'corp', 'MarketOrders');
        $this->_parseMarketOrders($corpMarketOrders, $this->dashboardItems);

        $this->dashboardItems = $this->_array_sort($this->dashboardItems, 'datetime');
        $this->_cleanup($this->dashboardItems, strtotime('1970-01-01'));
       
        $this->set('Corporations', $this->AleApi->getCorporations($this->apis));
        $this->set('EveRamActivity', $this->EveRamActivity->toArray());
        $this->set('DashboardItems', $this->dashboardItems);
    }
    
    private function _parseMarketOrders($charMarketOrders, &$arr) {
            
        // The duration for the market orders
        $duration = 24 * 60 * 60;
        $created = time();
        
        $i = sizeof($arr);
        foreach ($charMarketOrders as $account => $characters) {
            foreach ($characters as $apiitem) {
                $marketOrder = $apiitem['api'];
                foreach ($marketOrder->getSimpleXMLElement()->rowset->row as $order) {
                    $arr[$i]['accountID'] = $this->Api->field('api_user_id',array(
                        'Api.id' => $account,
                        'Api.user_id' => $this->loggedUser['id'])
                    );
                    $arr[$i]['characterID'] = $apiitem['characterID'];
                    $arr[$i]['corporationID'] = $apiitem['corporationID'];
                    $arr[$i]['apitype'] = $apiitem['type'];
                    $arr[$i]['type'] = 'MarketOrder';
                    $attributes = $order->attributes();
                    foreach ($attributes as $attributeName => $attributeValue) {
                        $attribName = trim((string)$attributeName);
                        $attribVal = trim((string)$attributeValue);
                        $arr[$i]['data'][$attribName] = $attribVal;
                    }
                    if (isset($arr[$i]['characterID'])) {
                        $exists = $this->DashboardHiddenItem->find(
                            'first',
                            array(
                                'conditions' => array(
                                    'DashboardHiddenItem.type' => 'char/MarketOrders',
                                    'DashboardHiddenItem.character_id' => $arr[$i]['characterID']
                                )
                            )
                        );
                    } else {
                        $exists = $this->DashboardHiddenItem->find(
                            'first',
                            array(
                                'conditions' => array(
                                    'DashboardHiddenItem.type' => 'corp/MarketOrders',
                                    'DashboardHiddenItem.character_id' => $arr[$i]['corporationID']
                                )
                            )
                        );
                    }

                    if ($exists===false) {
                        $created = time() - $duration;
                    }
                    
                    if ($arr[$i]['data']['orderState']!=0) {
                        if ($arr[$i]['data']['orderState']==2) {
                            if (isset($arr[$i]['characterID'])) {
                                $item = $this->DashboardHiddenItem->find(
                                    'first',
                                    array(
                                        'conditions' => array(
                                            'DashboardHiddenItem.type' => 'char/MarketOrders',
                                            'DashboardHiddenItem.character_id' => $arr[$i]['characterID'],
                                            'DashboardHiddenItem.api_id' => $arr[$i]['data']['orderID']
                                        )
                                    )
                                );
                            } else {
                                $item = $this->DashboardHiddenItem->find(
                                    'first',
                                    array(
                                        'conditions' => array(
                                            'DashboardHiddenItem.type' => 'corp/MarketOrders',
                                            'DashboardHiddenItem.character_id' => $arr[$i]['corporationID'],
                                            'DashboardHiddenItem.api_id' => $arr[$i]['data']['orderID']
                                        )
                                    )
                                );
                            }  
                            if ($item===false) {
                                $this->DashboardHiddenItem->id = null;
                                if (isset($arr[$i]['characterID'])) {
                                    $this->DashboardHiddenItem->set('type', 'char/MarketOrders');
                                    $this->DashboardHiddenItem->set('character_id', $arr[$i]['characterID']);
                                } else {
                                    $this->DashboardHiddenItem->set('type', 'corp/MarketOrders');
                                    $this->DashboardHiddenItem->set('character_id', $arr[$i]['corporationID']);
                                }
                                $this->DashboardHiddenItem->set('api_id', $arr[$i]['data']['orderID']);
                                $this->DashboardHiddenItem->save();
                                $this->DashboardHiddenItem->set('created', date('Y-m-d H:i:s', $created));
                                $this->DashboardHiddenItem->save();
                                $c = $created;
                            } else {
                                $c = strtotime($item['DashboardHiddenItem']['created']);
                            }
                            if ($c > time() - $duration) {
                                $arr[$i]['type'] = 'MarketOrderExpired';
                                $arr[$i]['datetime'] = date('Y-m-d H:i:s', $c);
                                $i++;
                            } else {
                                unset($arr[$i]);
                            }
                        } else {
                            unset($arr[$i]);
                        }
                    } else {
                        $arr[$i]['datetime'] = date('Y-m-d H:i:s', strtotime($arr[$i]['data']['issued']) + ($arr[$i]['data']['duration'] * 24 * 60 * 60));
                        // Remove duplicates
                        for ($j=0; $j < $i; $j++) {
                            if (isset($arr[$j]['data']['orderID'])) {
                                if ($arr[$j]['data']['orderID']==$arr[$i]['data']['orderID']) {
                                    unset($arr[$i]);
                                    $i--;
                                }
                            } 
                        }
                        $i++;
                    }
                }
            }
        }
        return $arr;
    }
    
    private function _parseSkillQueue($charSkillQueue, &$arr) {
        $i = sizeof($arr);
        foreach($charSkillQueue as $account => $characters) {
            foreach ($characters as $item) {
                $skills = $item['api'];
                if (isset($skills->getSimpleXMLElement()->rowset->row[0])) {
                    $lastrow = null;
                    foreach ($skills->getSimpleXMLElement()->rowset->row as $skill) {
                        $arr[$i]['accountID'] = $this->Api->field('api_user_id',array(
                            'Api.id' => $account,
                            'Api.user_id' => $this->loggedUser['id'])
                        );
                        $arr[$i]['characterID'] = $item['characterID'];
                        $arr[$i]['corporationID'] = $item['corporationID'];
                        $arr[$i]['type'] = 'SkillQueue';
                        $arr[$i]['apitype'] = 'char';
                        $attributes = $skill->attributes();
                        foreach ($attributes as $attributeName => $attributeValue) {
                            $attribName = trim((string)$attributeName);
                            $attribVal = trim((string)$attributeValue);
                            $arr[$i]['data'][$attribName] = $attribVal;
                        }
                        $arr[$i]['datetime'] = $arr[$i]['data']['endTime'];
                        if (($lastrow==null) || ($arr[$i]['data']['queuePosition'] > $lastrow['queuePosition'])) {
                            $lastrow = array(
                                'queuePosition' => $arr[$i]['data']['queuePosition'],
                                'endTime' => $arr[$i]['data']['endTime']
                            );
                        }
                        $i++;
                    }
                    if ($lastrow!=null) {
                        $arr[$i] = array(
                            'accountID' => $this->Api->field('api_user_id',array(
                                    'Api.id' => $account,
                                    'Api.user_id' => $this->loggedUser['id'])
                                ),
                            'characterID' => $item['characterID'],
                            'corporationID' => $item['corporationID'],
                            'apitype' => 'char',
                            'type' => 'SkillQueueFree',
                            'datetime' => date('Y-m-d H:i:s', strtotime($lastrow['endTime']) - 24 * 60 * 60)
                        );
                        $i++;
                    }
                }
            }
        }
        return $arr;
    }
     
    private function _parseIndustryJobs($industryJobs, &$arr) {
        
        $i = sizeof($arr);
        foreach($industryJobs as $account => $characters) {
            foreach ($characters as $item) {
                $jobs = $item['api'];
                $corp = $item['corporationID'];
                foreach ($jobs->getSimpleXMLElement()->rowset->row as $job) {
                    $arr[$i]['accountID'] = $this->Api->field('api_user_id',array(
                        'Api.id' => $account,
                        'Api.user_id' => $this->loggedUser['id'])
                    );
                    $arr[$i]['characterID'] = $item['characterID'];
                    $arr[$i]['corporationID'] = $item['corporationID'];
                    $arr[$i]['apitype'] = $item['type'];
                    $arr[$i]['type'] = 'IndustryJob';
                    $attributes = $job->attributes();
                    foreach ($attributes as $attributeName => $attributeValue) {
                        $attribName = trim((string)$attributeName);
                        $attribVal = trim((string)$attributeValue);
                        $arr[$i]['data'][$attribName] = $attribVal;
                    }
                    if ($arr[$i]['data']['completed']==1) {
                        unset($arr[$i]);
                    } else {
                        // Remove duplicates
                        $arr[$i]['datetime'] = $arr[$i]['data']['endProductionTime'];
                        for ($j=0; $j < $i; $j++) {
                            if (isset($arr[$j]['data']['jobID'])) {
                                if ($arr[$j]['data']['jobID']==$arr[$i]['data']['jobID']) {
                                    unset($arr[$i]);
                                    $i--;
                                }
                            } 
                        }
                        $i++;
                    }
                }
            }
        }
        return $arr;
    }

    private function _cleanup(&$arr, $datetime) {
        foreach($arr as $key => $value) {
            if (strtotime($value['datetime']) <= $datetime) {
                unset($arr[$key]);
            }
        }
    }

    private function _array_sort($array, $on, $order=SORT_ASC) {
        $new_array = array();
        $sortable_array = array();
    
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
    
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }
    
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
    
        return $new_array;
    }
    
}
?>