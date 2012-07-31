<?php

/**
 * Model for table 'invGroups'
 * 
 * This table contain groups for items. Groups belong to Categories. Also here listed parameters common to all items in group.
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * groupID                                              X       Unique ID of group. Should be primary key.
 * categoryID       invCategories.categoryID            X       Category this group belongs to.
 * groupName                                            X       Name of group.
 * description                                          X       Description of group.
 * graphicID        eveGraphics.graphicID               X       Graphic used for group, if applicable.
 * useBasePrice                                         X       Should game use base price for items in this group.
 * allowManufacture                                     X       Items in this group can be manufactured.
 * allowRecycler                                        X       Items in this group can be recycled.
 * anchored                                             X       Items in this group are anchored.
 * anchorable                                           X       Items in this group can be anchored.
 * fittableNonSingleton                                 X       Items in this group can be fit in quantities (i.e. Smartbombs).
 * published                                            X       1 if group is in game.
 * 
 * @author Willi Thiel
 * @date 2010-09-03
 * @version 1.0
 */
class EveInvGroup extends AppModel {

    // Model Attributes
    var $name               = 'EveInvGroup';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'invGroups';
    var $primaryKey         = 'groupID';
    var $displayField       = 'groupName';
    var $recursive          = 2;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $hasMany = array(
        'EveInvType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'groupID',
            'dependent'     => false
        ),
    );

    var $belongsTo = array(
        'EveInvCategory' => array(
            'className'     => 'EveInvCategory',
            'foreignKey'    => 'categoryID',
            'dependent'     => false
        ),
        'EveGraphic' => array(
            'className'     => 'EveEveGraphic',
            'foreignKey'    => 'graphicID',
            'dependet'      => false
        )
    );
  
}

?>