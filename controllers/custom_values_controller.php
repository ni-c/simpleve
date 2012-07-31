<?php

/**
 * Controller for the CustomValues model.
 * 
 * @author Willi Thiel
 * @date 2010-09-02
 * @version 0.2
 */
class CustomValuesController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'CustomValues';
    
    /**
     * An array containing the class names of models this controller uses.
     *
     * - EveInvType 
     * - EveInvTypeMaterial 
     */
    var $uses = array('CustomValue');

    var $allowedValueTypes = array(
        'price',
        'me',
        'pe',
        'standing',
        'manufacturingtimemultiplier',
        'manufacturinghourcost',
        'manufacturinginstallcost',
        'copytimemultiplier',
        'copyhourcost',
        'copyinstallcost'
        );
    
    function beforeFilter() {
        $this->Auth->allow('getAllowedValueTypes');
        
        $this->Auth->mapActions(
            array(
                'read' => array('getAllowedValueTypes'),
            )
        );
    }
    
    function beforeRender() {
        
    }

    function getAllowedValueTypes() {
        $this->autoRender = false;
        return $this->allowedValueTypes;
    }

    function edit() {
        if (isset($_POST)) {
            if ((!isset($_POST['valueType'])) ||
                (!isset($_POST['invTypeID'])) || 
                (!isset($_POST['value'])) ||
                (!in_array($_POST['valueType'], $this->allowedValueTypes))) {
                echo 'Invalid valueType';
                $this->autoRender = false; 
                exit();
                return;
            }
            
            if (!$this->__setLoggedUserValues()) {
                return;
            }
            
            $this->CustomValue->unbindModel(array('belongsTo' => array('User', 'EveInvType')));
            $CustomValue = $this->CustomValue->find('first', 
                array('conditions' => 
                    array(
                        'CustomValue.user_id' => $this->loggedUser['id'],
                        'CustomValue.value_type' => $_POST['valueType'],
                        'CustomValue.eve_inv_type_id' => $_POST['invTypeID']
                    ),
                )
            );
            if (!isset($CustomValue['CustomValue']['id'])) {
                $CustomValue = array();
                $CustomValue['CustomValue'] = array();
                $CustomValue['CustomValue']['value_type'] = $_POST['valueType'];
                $CustomValue['CustomValue']['eve_inv_type_id'] = $_POST['invTypeID'];
            } else {
                $this->CustomValue->id = $CustomValue['CustomValue']['id'];
            }
            $CustomValue['CustomValue']['user_id'] = $this->loggedUser['id'];
            $CustomValue['CustomValue']['value'] = (float)$_POST['value'];
            unset($CustomValue['CustomValue']['modified']);
            $this->CustomValue->save($CustomValue);
        }
        $this->autoRender = false; 
        exit();
    }
}
?>
