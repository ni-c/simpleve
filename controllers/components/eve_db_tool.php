<?php

/**
 * EveDbTool component, used to get common things from the database
 * 
 * @author Willi Thiel
 * @date 2010-09-18
 * @version 1.0
 */
class EveDbToolComponent extends Object {
    
    /**
     * The parent controller of this component.
     */
    var $controller = null;
    
     function init(&$controller)
    {
        $this->controller = $controller;
    }

    function getRequiredSkills($type_id) {
        
        $required_skills = array();
        $eve_dgm_type_attributes = $this->controller->EveDgmTypeAttribute->find('all', array('conditions' => array('EveDgmTypeAttribute.typeID' => $type_id)));
        
        foreach ($eve_dgm_type_attributes as $eve_dgm_type_attribute) {
            for ($i=1; $i < 7; $i++) { 
                if ($eve_dgm_type_attribute['EveDgmAttributeType']['attributeName'] == 'requiredSkill'.$i) {
                    if (!isset($required_skills[$i])) {
                        $required_skills[$i] = array();
                    }
                    $required_skills[$i]['skill_id'] = $eve_dgm_type_attribute['EveDgmTypeAttribute']['valueInt'];
                }
                if ($eve_dgm_type_attribute['EveDgmAttributeType']['attributeName'] == 'requiredSkill'.$i.'Level') {
                    if (!isset($required_skills[$i])) {
                        $required_skills[$i] = array();
                    }
                    $required_skills[$i]['level'] = $eve_dgm_type_attribute['EveDgmTypeAttribute']['valueInt'];
                }
            }
        }
        return $required_skills;
    }
}
?>