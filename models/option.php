<?php

/**
 * Model for table 'se_option'
 * 
 * Contains all user options.
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the option.
 * user_id              User.id                         X       id of the user that the option belongs to.
 * key                                                  X       the key of the option.
 * value                                                X       the value of the option.
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-14
 * @version 1.0
 */
class Option extends AppModel {

    // Model Attributes
    var $name               = 'Option';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'options';
    var $primaryKey         = 'id';
    var $displayField       = 'key';
    var $recursive          = 1;
    
    var $belongsTo = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'user_id',
            'dependent'     => false
        ),
    ); 

}
?>