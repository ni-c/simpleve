<?php

/**
 * Model for table 'invCategories'
 * 
 * Categories. So we have simple 2-level hierarchy: Category -> Group.
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * categoryID                                           X       Unique ID of category. Should be primary key.
 * categoryName                                         X       Name of Category.
 * description                                          X       Description of Category.
 * graphicID        eveGraphics.graphicID               X       Graphic for this category.
 * published                                            X       1 if category is in game. 
 * 
 * @author Willi Thiel
 * @date 2010-09-03
 * @version 1.0
 */
class EveInvCategory extends AppModel {

    // Model Attributes
    var $name               = 'EveInvCategory';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'invCategories';
    var $primaryKey         = 'categoryID';
    var $displayField       = 'categoryName';
    var $recursive          = 2;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
    var $hasMany = array(
        'EveInvGroup' => array(
            'className'     => 'EveInvGroup',
            'foreignKey'    => 'categoryID',
            'dependent'     => false
        )
    );
  
    var $belongsTo = array(
        'EveGraphic' => array(
            'className'     => 'EveEveGraphic',
            'foreignKey'    => 'graphicID',
            'dependet'      => false
        )
    );

}

?>