<?php

/**
 * Controller for the eve api
 * 
 * @author Willi Thiel
 * @date 2010-10-03
 * @version 1.0
 */
class EveApiController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'EveApi';

    /**
     * An array containing the class names of models this controller uses.
     *
     * - User for modifying user datasets
     * - Ticket for activation and retrievepassword eMails
     */
    var $uses = array(
        'ApiMapSovereignty',
        'ApiMapSovereigntyChanges',
        'ApiEveAllianceList'
    );
        
    function beforeFilter() {

        $this->Auth->allow(
            'update',
            'lastsovereigntychanges',
            'get',
            'getCharacterName',
            'getCorporationName'
        );
        parent::beforeFilter();
    }
    
    function update($api, $type) {
        
        $this->autoRender = false;
        
        switch(strtolower($type)) {
            case 'sovereignty':
                $this->_updateSovereignty();
                break;
            default:
                $apiResult = $this->AleApi->requestApi($api, $type);
                $model = 'Api' . ucfirst($api) . $type;
                $this->$model->deleteAll('1 = 1', false);
                $this->$model->query('ALTER TABLE `' . $this->$model->useTable . '` AUTO_INCREMENT = 1;');
                foreach ($apiResult->getSimpleXMLElement()->result->rowset->row as $item) {
                    $dataset = array();
                    $attributes = $item->attributes();
                    foreach ($attributes as $attributeName => $attributeValue) {
                        $attribName = trim((string)$attributeName);
                        $attribVal = trim((string)$attributeValue);
                        $dataset[$attribName] = $attribVal;
                    }
                    $this->$model->id = null;
                    $this->$model->set($dataset);
                    $this->$model->save();
                }
                break;
        }
        echo 'done.';
    }

    function lastsovereigntychanges($num = 8) {
        $this->autoRender = false;
        return $this->ApiMapSovereigntyChanges->find('all', 
            array(
                'limit' => $num,
                'order' => array('ApiMapSovereigntyChanges.created DESC'),
            )
        );
    }
    
    function get($api, $type, $field, $value) {
        $this->autoRender = false;
        $model = 'Api' . ucfirst($api) . $type;
        return $this->$model->find('all', 
            array('conditions' => array($field => $value))
        );
    }

    function getCharacterName($id) {
        $character = $this->AleApi->requestApi('eve', 'CharacterName', array('ids' => $id));
        $attributes = $character->getSimpleXMLElement()->result->rowset->row[0]->attributes();
        return $attributes['name'];
    }
    
    function getCorporationName($id) {
        $corporation = $this->AleApi->requestApi('corp', 'CorporationSheet', array('corporationID' => $id));
        $attributes = $corporation->getSimpleXMLElement()->result->rowset->row[0]->attributes();
        return $attributes['name'];
    }
    
    private function _updateSovereignty() {
        $mapSovereignty = $this->AleApi->requestApi('map', 'Sovereignty');
        foreach ($mapSovereignty->getSimpleXMLElement()->result->rowset->row as $solarSystem) {
            $dataset = array();
            $attributes = $solarSystem->attributes();
            $id = $this->ApiMapSovereignty->field('id', array('solarSystemID' => $attributes['solarSystemID']));
            if ($id!==false) {
                $this->ApiMapSovereignty->id = $id;   
                $oldAllianceID = $this->ApiMapSovereignty->field('allianceID', array('solarSystemID' => $attributes['solarSystemID']));
                if ((string)$oldAllianceID != $attributes['allianceID']) {
                    if ((string)$oldAllianceID!='0') {
                        $this->ApiMapSovereigntyChanges->id = null;
                        $this->ApiMapSovereigntyChanges->set('action', 'Lost');
                        $this->ApiMapSovereigntyChanges->set('solarSystemID', $attributes['solarSystemID']);
                        $this->ApiMapSovereigntyChanges->set('allianceID', $oldAllianceID);
                        $this->ApiMapSovereigntyChanges->save();
                    }
                    if ($attributes['allianceID']!='0') {
                        $this->ApiMapSovereigntyChanges->id = null;
                        $this->ApiMapSovereigntyChanges->set('action', 'Gain');
                        $this->ApiMapSovereigntyChanges->set('solarSystemID', $attributes['solarSystemID']);
                        $this->ApiMapSovereigntyChanges->set('allianceID', $attributes['allianceID']);
                        $this->ApiMapSovereigntyChanges->save();
                    }
                }
            } else {
                $this->ApiMapSovereignty->id = null;
            }
            foreach ($attributes as $attributeName => $attributeValue) {
                $attribName = trim((string)$attributeName);
                $attribVal = trim((string)$attributeValue);
                $dataset[$attribName] = $attribVal;
            }
            $this->ApiMapSovereignty->set($dataset);
            $this->ApiMapSovereignty->save();
        }
    }
}
?>
