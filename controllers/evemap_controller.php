<?php

/**
 * Controller for the Map.
 * 
 * @author Willi Thiel
 * @date 2010-09-19
 * @version 1.0
 */
class EvemapController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Evemap';
    
    var $uses = array('EveMapSolarSystem');
    
    function beforeFilter() {
        $this->Auth->mapActions(
            array(
                'read' => array('getSolarSystems'),
            )
        );
    }

    function getSolarSystems($region) {
        return $this->MineralIndexType->find('all',
            array(
                'conditions' => array(
                    'regionID' => $region,
                    'security >' => 0.5,
                )
            )
        );
        $this->autoRender = false;
    }
}
?>
