<?php

/**
 * Controller for the MineralIndexTypes.
 * 
 * @author Willi Thiel
 * @date 2010-09-19
 * @version 1.0
 */
class MineralIndexTypesController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'MineralIndexTypes';
    
    var $uses = array('MineralIndexType', 'MineralIndex');
    
    var $updatecycle = 75600; // (21 * 60 * 60)
        
    function beforeFilter() {

        $this->Auth->allow('update', 'getAll');
        $this->Auth->mapActions(
            array(
                'read' => array('getAll'),
            )
        );
        App::import('Vendor', 'ale/factory');
    }

    function beforeRender() {
        
    }

    function getAll() {
        $this->autoRender = false;
        return $this->MineralIndexType->find('all');
    }
    
    function update() {
        $this->autoRender = false;
        $result = array();
        echo '<pre>';
        echo 'Updateding mineral prices where "created" > ' . date('Y-m-d H:i', (time() - $this->updatecycle)) . '<br />';
        $MineralIndexTypes = $this->MineralIndexType->find('all');
        foreach ($MineralIndexTypes as $MineralIndexType) {
            $id = $MineralIndexType['MineralIndexType']['eve_inv_type_id'];
            $exists = $this->MineralIndex->find('first', 
                array('conditions' => 
                    array('MineralIndex.eve_inv_type_id' => $id,
                          'MineralIndex.created > ' => date('Y-m-d H:i', (time() - $this->updatecycle))
                    )     
                )
            );
            if ($exists===false) {
                $MarketStat = $this->AleApi->getEveCentralMarketStat($id);
                $price = (float)$MarketStat->marketstat->type->all->median;
                $MineralIndex = array();
                $MineralIndex['MineralIndex'] = array();
                $MineralIndex['MineralIndex']['eve_inv_type_id'] = $id;
                $MineralIndex['MineralIndex']['price'] = $price;
                $result[$id] = $MineralIndex; 
                $this->MineralIndex->id = null;
                $this->MineralIndex->save($MineralIndex);
            }
        }
        print_r($result);
        echo '</pre>';
    }
}
?>
