<?php

/**
 * Model for table 'invMetaType'
 * 
 * Relation between different variants of item (i.e. Tech-I, Faction, Tech-II). These are not "meta-levels" of items used for calculate invention success. 
 * For that information see Attribute metaLevel (attributeID=633) in table dgmTypeAttributes linked with typeID in question.
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * typeID           invTypes.typeID                     X       Item in question.
 * parentTypeID     invTypes.typeID                     X       Parent (i.e. Meta-0) item.
 * metaGroupID      invMetaGroups.metaGroupID           X       Meta-group.
 * 
 * @author Willi Thiel
 * @date 2010-09-12
 * @version 1.0
 */


 
class EveInvMetaType extends AppModel {

    // Model Attributes
    var $name               = 'EveInvMetaType';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'invMetaTypes';
    var $primaryKey         = 'typeID';
    var $displayField       = 'parentTypeID';
    var $recursive          = 1;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $hasOne = array(
        'EveInvType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'typeID',
            'dependent'     => false
        ),
    );

    var $belongsTo = array(
        'ParentEveInvType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'parentTypeID',
            'dependet'      => false
        )
    );
  
}

?>