<?php

/**
 * Model for table 'se_groups'
 * 
 * Contains all groups.
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the group.
 * name                                                 X       the name of the group.
 * parent_id                                            X       id of the parent group.
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-05
 * @version 1.0
 */
class Group extends AppModel {

    // Model Attributes
    var $name               = 'Group';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'groups';
    var $primaryKey         = 'id';
    var $displayField       = 'name';
    var $recursive          = -1;
    
    var $validate = array(
        'name' => array(
            'rule' => array('between', 3, 50),
            'required' => true,
            'message' => 'Groupnames must be between 3 and 50 characters long.'
        ),
    );

    var $hasMany = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'group_id',
            'dependent'     => false
        ),
    ); 
}

?>