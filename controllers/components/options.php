<?php

/**
 * The Option component gets options from the database
 * 
 * @author Willi Thiel
 * @date 2010-09-14
 * @version 1.0
 */
class OptionsComponent extends Object {
    
    /**
     * The parent controller of this component.
     */
    var $controller = null;
    
    function init(&$controller)
    {
        $this->controller = $controller;
    }
     
     /**
      * Gets the general option from the database
      */
    function getGeneral($key = null) {
        return $this->_get($key, 0);
    }
    
    /**
     * Sets the general option, deletes it from db if $value = false
     */
    function setGeneral($key, $value) {
        return $this->_set($key, $value, 0);
    }
     
    /**
     * Get the option for the current user or false if not set, if no parameter is set, all options are returned
     */
    function get($key = null) {
        return $this->_get($key, $this->controller->loggedUser['id']);
    }
    
    /**
     * Sets the option for the current user, deletes it from db if $value = false
     */
    function set($key, $value) {
        return $this->_set($key, $value, $this->controller->loggedUser['id']);
    }
         
    function _get($key, $user_id) {
        if ($key!=null) {
            if ($this->controller->Option->find('count', array('conditions' => array('Option.user_id' => $user_id, 'Option.key' => $key)))>0) {
                $result = $this->controller->Option->find('first', array('conditions' => array('Option.user_id' => $user_id, 'Option.key' => $key)));
                return $result['Option']['value'];
            } else {
                return false;
            } 
        } else {
            $options = $this->controller->Option->find('all', array('conditions' => array('Option.user_id' => $user_id)));
            $result = array();
            foreach ($options as $option) {
                $result[$option['Option']['key']] = $option['Option']['value'];
            }
            return $result;
        }
    }
    
    /**
     * Sets the option, deletes it from db if $value = false
     */
    function _set($key, $value, $user_id) {
        if ($value===false) {
            $this->controller->Option->deleteAll(array('Option.user_id' => $user_id, 'Option.key' => $key));
        } else {
            if ($this->controller->Option->find('count', array('conditions' => array('Option.user_id' => $user_id, 'Option.key' => $key)))>0) {
                $option = $this->controller->Option->find('first', array('conditions' => array('Option.user_id' => $user_id, 'Option.key' => $key)));
            } else {
                $option = array();
                $option['Option'] = array();
                $this->controller->Option->id = null;
            }
            $option['Option']['user_id'] = $user_id;
            $option['Option']['key'] = $key;
            $option['Option']['value'] = $value;
            $this->controller->Option->set($option);
            $this->controller->Option->save();
        }
    }
    
}
?>