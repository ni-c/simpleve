<?php

/**
 * Model for table 'dgmAttributeTypes'
 * 
 * Names and descriptions of attributes. 
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * attributeID      dgmTypeAttributes.attributeID       X       Unique ID of attribute. Should be primary key.
 * attributeName                                        X       Name of attribute.
 * description                                          X       Description of attribute.
 * graphicID        eveGraphics.graphicID               X       Graphic for attribute.
 * defaultValue                                         X       Default value for attribute.
 * published                                            X       1 if attribute is in game.
 * displayName                                          X       Name of attribute as displayed in game.
 * unitID           eveUnits.unitID                     X       Measurement unit for attribute.
 * stackable                                            X       1 if attribute does not suffer from Stacking penalty effect.
 * highIsGood                                           X       1 if high value of attribute is good for player.
 * categoryID       dgmAttributeCategories.categoryID   X       Attribute Category ID. 
 * 
 * @author  Willi Thiel
 * @date    2010-09-18
 * @version 0.1
 */
 
class EveDgmAttributeType extends AppModel {

    // Model Attributes
    var $name               = 'EveDgmAttributeType';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'dgmAttributeTypes';
    var $primaryKey         = 'attributeID';
    var $displayField       = 'attributeName';
    var $recursive          = 0;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $belongsTo = array(
        'EveDgmTypeAttribute' => array(
            'className'     => 'EveDgmTypeAttribute',
            'foreignKey'    => 'attributeID',
            'dependent'     => false
        )
    );
    
}

?>