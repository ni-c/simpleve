<?php

/**
 * Controller for the Options.
 * 
 * @author Willi Thiel
 * @date 2010-09-17
 * @version 1.0
 */
class OptionsController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Options';
    
    /**
     * An array containing the class names of models this controller uses.
     */
    var $uses = array();
    
    function index() {
        
    }

    function edit() {
        if (isset($_POST)) {
            $this->Options->set($_POST['key'], $_POST['value']);
        }
        $this->autoRender = false; 
    }
}
?>
