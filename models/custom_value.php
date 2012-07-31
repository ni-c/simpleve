<?php

/**
 * Model for table 'se_custom_values'
 * 
 * Contains custom values of registered users.
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the price mapping.
 * user_id              User.id                         X       id of the user.
 * value_type                                           X       Type of the value (price, me, pe)
 * eve_material_type_id EveInvType.typeID               X       ID of the material in the static eve dump
 * value                                                X       The value of the material
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-12
 * @version 1.0
 */
class CustomValue extends AppModel {

    // Model Attributes
    var $name               = 'CustomValue';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'custom_values';
    var $primaryKey         = 'id';
    var $displayField       = 'value';
    var $recursive          = 1;
    
    var $belongsTo = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'user_id',
            'dependent'     => false
        ),
        'EveInvType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'eve_material_type_id',
            'dependent'     => false
        ),
    ); 
}

?>