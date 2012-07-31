<?php

/**
 * Model for table 'ramTypeRequirements'
 * 
 * Extra items required by blueprints to build or research.
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * typeID           invBlueprintTypes.blueprintTypeID   X       typeID of blueprint.
 * activityID       ramActivities.activityID            X       activity for which this material is needed.
 * requiredTypeID   invTypes.typeID                     X       typeID of the required material.
 * quantity                                             X       Quantity of required material.
 * damagePerJob                                         X       How much of this material is used (from 0.0 to 1.0).
 * recycle                                              X       When manufacturing, the components of this material (see invTypeMaterials) are subtracted from the product's materials. 
 *                                                              See also Bill of Materials. 
 * 
 * @author  Willi Thiel
 * @date    2010-09-02
 * @version 0.1
 */
class EveRamTypeRequirement extends AppModel {

    // Model Attributes
    var $name               = 'EveRamTypeRequirement';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'ramTypeRequirements';
    var $primaryKey         = 'typeID';
    var $displayField       = 'requiredTypeID';
    var $recursive          = 2;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $belongsTo = array(
        'EveInvType'  => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'requiredTypeID',
            'dependent'     => false
        ),
        'EveRamActivity'  => array(
            'className'     => 'EveRamActivity',
            'foreignKey'    => 'activityID',
            'dependent'     => false
        )
    );
/*  
    var $hasOne = array(
        'EveInvBlueprintType' => array(
            'className'     => 'EveInvBlueprintType',
            'foreignKey'    => 'blueprintTypeID',
            'dependent'     => false
        )
    );
*/
}

?>