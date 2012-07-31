<?php

/**
 * Model for table 'invBlueprintTypes'
 * 
 * Information about blueprints. Units/run can be retrieved from the invTypes table.
 * 
 * Column                       Links to                    Used    Note
 * ==========================================================================================================================================================================================
 * blueprintTypeID              invTypes.typeID             X       typeID of this blueprint.
 * parentBlueprintTypeID        invTypes.typeID             X       typeID of parent (i.e. tech-I for tech-II blueprints) blueprint. <-- This seems inaccurate. The few that aren't set to null seem to have invalid data.
 * productTypeID                invTypes.typeID             X       typeID of produced item.
 * productionTime                                           X       Base production time.
 * techLevel                                                X       Tech level of blueprint.
 * researchProductivityTime                                 X       Base time of Productivity Research.
 * researchMaterialTime                                     X       Base time of Material Research.
 * researchCopyTime                                         X       Base time of Blueprint Copying. Note that this is the amount of time taken to copy a number of runs equal to half the maxProductionLimit, whether as multiple runs on one copy or as one run each on multiple copies.
 * researchTechTime                                                 Base time of Tech Research. Not implemented.
 * productivityModifier                                     X       Used in the equation of manufacturing time (time + (1 - PE) * modifier).
 * materialModifier                                                 Base mineral modifier??
 * wasteFactor                                              X       Waste factor for materials.
 * chanceOfReverseEngineering                                       Chance of reverse engineering. Not implemented.
 * maxProductionLimit                                       X       Limit of production runs on single blueprint. Also maximum runs for Blueprint Copy of this item.  * 
 *  
 * @author Willi Thiel
 * @date 2010-09-03
 * @version 1.0
 */
class EveInvBlueprintType extends AppModel {

    // Model Attributes
    var $name               = 'EveInvBlueprintType';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'invBlueprintTypes';
    var $primaryKey         = 'blueprintTypeID';
    var $displayField       = 'blueprintTypeID';
    var $recursive          = 2;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $belongsTo = array(
        'Blueprint_EveInvType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'blueprintTypeID',
            'dependent'     => false
        ),
/* This seems invalid        
        'Parent_EveBlueprintType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'parentBlueprintTypeID',
            'dependent'     => false
        ),
*/  
    );
}

?>