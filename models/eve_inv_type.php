<?php

/**
 * Model for table 'invTypes'
 * 
 * This table contains all ingame items. It's source of all queries related to Ships, Modules, Skills, etc. It doesn't contain actual space objects data, only types of objects (i.e. Large Gas Planet I).
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * typeID                                               X       Unique ID of item in game. Should be primary key.
 * groupID              invGroups.groupID               X       Group this item belongs to. It's not Market group. Also Groups belong to Categories.
 * typeName                                             X       Name of item, i.e. Rogue Medium Commander Wreck.
 * description                                          X       Description as seen in Info window in game.
 * graphicID            eveGraphics.graphicID           X       Link to graphic used in game for this item.
 * radius                                               X       Radius of item, if applicable.
 * mass                                                 X       Mass of item, if applicable.
 * volume                                               X       Volume of item, if applicable.
 * capacity                                             X       Holding capacity of item, if applicable.
 * portionSize                                          X       Portion size of item, if applicable. Portion size is size of group for reprocessing purposes, for example. It also represents 
 *                                                              the number of units produced by a production run of the item.
 * raceID                                               X       Which race(s) this item belongs to. Races are bitmask, by the way.
 * basePrice                                            X       Base price of item. Have no relation to actual market price.
 * published                                            X       1 if item is published in the game market.
 * marketGroupID        invMarketGroups.marketGroupID   X       Market group of item. If NULL, the item cannot be sold on the market.
 * chanceOfDuplicating                                          Chance of duplicating item. Duplication process is not implemented. * Model for the invTypes table.
 * 
 * @author Willi Thiel
 * @date 2010-09-01
 * @version 1.0
 */
class EveInvType extends AppModel {

    // Model Attributes
    var $name               = 'EveInvType';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'invTypes';
    var $primaryKey         = 'typeID';
    var $displayField       = 'typeName';
    var $recursive          = 2;
    var $order              = 'typeName DESC';
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $hasOne = array(
        'Product_EveInvBlueprintType' => array(
            'className'     => 'EveInvBlueprintType',
            'foreignKey'    => 'productTypeID',
            'dependent'     => false
        ),
/* This seems invalid
        'Parent_EveInvBlueprintType' => array(
            'className'     => 'EveInvBlueprintType',
            'foreignKey'    => 'parentBlueprintTypeID',
            'dependent'     => false
        ),
 */
    );
    
    var $hasMany = array(
       'EveInvTypeMaterial' => array(
            'className'     => 'EveInvTypeMaterial',
            'foreignKey'    => 'typeID',
            'dependent'     => false
        ),
        'EveRamTypeRequirement' => array(
            'className'     => 'EveRamTypeRequirement',
            'foreignKey'    => 'typeID',
            'dependent'     => false
        ),
    );
   
    var $belongsTo = array(
        'EveInvGroup' => array(
            'className'     => 'EveInvGroup',
            'foreignKey'    => 'groupID',
            'dependent'     => false
        ),
        'EveGraphic' => array(
            'className'     => 'EveGraphic',
            'foreignKey'    => 'graphicID',
            'dependet'      => false
        ),
        'EveInvMetaType' => array(
            'className'     => 'EveInvMetaType',
            'foreignKey'    => 'typeID',
            'dependent'     => false
        ),
    ); 
  // @TODO Link to invMarketGroups

}

?>