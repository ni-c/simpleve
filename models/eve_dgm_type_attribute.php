<?php

/**
 * Model for table 'dgmTypeAttributes'
 * 
 * All attributes for items. Only one value of attribute exists per table row. 
 * Correct way to obtain value is isNULL(valueInt,valueFloat) in MS SQL or IFNULL(valueInt,valueFloat) in mySQL. 
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * typeID           invTypes.typeID                     X       Item ID.
 * attributeID      dgmAttributeTypes.attributeID       X       Attribute ID.
 * valueInt                                             X       Integer value of attribute.
 * valueFloat                                           X       Float value of attribute.
 * 
 * @author  Willi Thiel
 * @date    2010-09-18
 * @version 0.1
 */
 
class EveDgmTypeAttribute extends AppModel {

    // Model Attributes
    var $name               = 'EveDgmTypeAttribute';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'dgmTypeAttributes';
    var $primaryKey         = 'attributeID';
    var $displayField       = 'attributeID';
    var $recursive          = 0;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $hasOne = array(
        'EveDgmAttributeType' => array(
            'className'     => 'EveDgmAttributeType',
            'foreignKey'    => 'attributeID',
            'dependent'     => false
        )
    );
    
}

?>