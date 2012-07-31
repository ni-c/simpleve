<?php

/**
 * Model for table 'se_apis'
 * 
 * Contains api keys
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the dataset.
 * user_id              User.id                         X       id of the user.
 * api_user_id                                          X       API User ID
 * api_key                                              X       API Key
 * is_active                                            X       1 if this API connection is active
 * errorcode                                            X       Last error code.
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-12
 * @version 1.0
 */
class Api extends AppModel {

    // Model Attributes
    var $name               = 'Api';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'apis';
    var $primaryKey         = 'id';
    var $displayField       = 'api_user_id';
    var $recursive          = 0;
        
    var $validate = array(
        'api_user_id' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'This User ID has already been taken.'
            ),
        ),
    );
    
    var $belongsTo = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'user_id',
            'dependent'     => false
        ),
    ); 
}

?>
