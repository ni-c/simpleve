<?php

/**
 * Model for table 'invTypeMaterials'
 * 
 * Material composition of items. This is used in reprocessing (when you have a stack of invTypes.portionSize), as well as in manufacturing (as materials affected by waste).
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * typeID               invTypes.typeID                 X       typeID of item.
 * materialTypeID       invTypes.typeID                 X       typeID of the component material.
 * quantity                                             X       Quantity of component material. 
 * 
 * @author Willi Thiel
 * @date 2010-09-01
 * @version 1.0
 */
class EveInvTypeMaterial extends AppModel {

    // Model Attributes
    var $name               = 'EveInvTypeMaterial';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'invTypeMaterials';
    var $primaryKey         = 'materialTypeID'; // & 'typeID' are primary key. Using first primary key here, because CakePHP doesn't support composite primary keys!
    var $displayField       = 'quantity';
    var $recursive          = 2;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $hasOne = array(
        'EveInvTypeMaterial' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'typeID',
            'dependent'     => false
        )
    );

    // Associations
    var $belongsTo = array(
        'EveInvType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'materialTypeID',
            'dependent'     => false
        )
    );
  
}

?>