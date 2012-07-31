<?php

/**
 * Controller to cache API request
 * 
 * @author Willi Thiel
 * @date 2010-09-25
 * @version 1.0
 */
class ApisController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Apis';
    
    /**
     * An array containing the class names of models this controller uses.
     */
    var $uses = array();

    function beforeFilter() {
        $this->Auth->mapActions(
            array(
                'read' => array('cacheSingle'),
            )
        );
    }
    
    function cacheSingle() {
        
        App::import('Controller', 'Prices');
        $Prices = new PricesController();
        if ((isset($_POST)) && (isset($_POST['typeID']))) {
            $id = $_POST['typeID'];
            if (isset($_POST['region'])) {
                $region = $_POST['region'];
            } else {
                $region = 'custom';
            }
            if (isset($_POST['type'])) {
                $type = $_POST['type'];
            } else {
                $type = 'buy';
            }
            $Prices->single($id, $region, $type);
        }
        $this->autoRender = false; 
    }
}
?>
