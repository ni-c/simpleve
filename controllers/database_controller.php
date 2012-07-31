<?php

/**
 * Controller for the requesting the database
 * 
 * @author Willi Thiel
 * @date 2010-10-03
 * @version 1.0
 */
class DatabaseController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Database';
    
    var $uses = array(
        'EveInvType',
        'EveMapSolarSystem',
        'EveMapRegion',
        'EveStaStation'
    );
    
    function beforeFilter() {

        $this->Auth->allow(
            'invtype',
            'mapsolarsystem',
            'mapregion',
            'stastation'
        );
    }
     
    function invtype($type, $recursive = -1) {
        $this->autoRender = false;
        $this->EveInvType->recursive = $recursive;
        if (is_numeric($type)) {
            return $this->EveInvType->find('first', array('conditions' => array('EveInvType.typeID' => $type)));
        } else {
            return $this->EveInvType->find('first', array('conditions' => array('EveInvType.typeName ' => $type)));
        }
    }
    
    function mapsolarsystem($solarSystemID) {
        $this->autoRender = false;
        $this->EveMapSolarSystem->recursive = -1;
        return $this->EveMapSolarSystem->find('first', array('conditions' => array('EveMapSolarSystem.solarSystemID' => $solarSystemID)));
    }
    
    function mapregion($regionID) {
        $this->autoRender = false;
        $this->EveMapRegion->recursive = -1;
        return $this->EveMapRegion->find('first', array('conditions' => array('EveMapRegion.regionID' => $regionID)));
    }

    function stastation($stationID) {
        $this->autoRender = false;
        $this->EveStaStation->recursive = -1;
        return $this->EveStaStation->find('first', array('conditions' => array('EveStaStation.stationID' => $stationID)));
    }
}