<?php

/**
 * Model for table 'se_user'
 * 
 * Contains all registered users.
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the user.
 * group_id             Group.id                        X       id of the group.
 * username                                             X       the username of the account.
 * password                                             X       the password as SHA1 hash.
 * email                                                X       the email adress of the user of this account.
 * is_active                                            X       1 if the user account is active.
 * expires                                              X       Timestamp until the account subscription expires.
 * balance                                              X       Balance of SimpleEve wallet.
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-03
 * @version 1.0
 */
class User extends AppModel {

    // Model Attributes
    var $name               = 'User';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'users';
    var $primaryKey         = 'id';
    var $displayField       = 'username';
    var $recursive          = 0;
    
    var $validate = array(
        'username' => array(
            'username_between' => array(
                'rule' => array('between', 3, 20),
                'required' => true,
                'message' => 'Usernames must be between 3 and 20 characters long.'
            ),
            'username_alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Usernames must only contain letters and numbers.'
            ),
            'username_isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This username has already been taken.'
            ),
        ),
        'passwd' => array(
            'password_between' => array(
                'rule' => array('between', 5, 15),
                'required' => true,
                'on' => 'create',
                'message' => 'Passwords must be between 5 and 15 characters long.',
            ),
            'identicalFieldValues' => array(
                'rule' => array('identicalFieldValues', 'passwd2' ),
                'message' => 'Passwords do not match.',
                'required' => true,
                'on' => 'create',
            )
        ),
        'passwd2' => array(
            'identicalFieldValues' => array(
                'rule' => array('identicalFieldValues', 'passwd' ),
                'required' => true,
                'on' => 'create',
                'message' => 'Passwords do not match.',
            )
        ),
        'email' => array(
            'email_email' => array(
                'rule' => array('email'),
                'required' => true,
                'message' => 'Email must be a valid email address.'
            ),
            'email_isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This email has already been taken.'
            ),
        ),
    );

    var $belongsTo = array(
        'Group' => array(
            'className'     => 'Group',
            'foreignKey'    => 'group_id',
            'dependent'     => false
        ),
    ); 

    var $hasMany = array(
        'Api' => array(
            'className'     => 'Api',
            'foreignKey'    => 'user_id',
            'dependent'     => false
        ),
        'Option' => array(
            'className'     => 'Option',
            'foreignKey'    => 'user_id',
            'dependent'     => false
        ),
    ); 
    
    function beforeSave() {
        if (isset($this->data['User']['passwd'])) {
            $auth = new AuthComponent();
            $this->data['User']['password'] = $auth->password($this->data['User']['passwd']);
            unset($this->data['User']['passwd']);
        }
        if (empty($this->data['User']['hash'])) {
            $this->data['User']['hash'] = $this->_str_rand();
        }
        return true;
    }
    
    function afterSave($created) {
        $aro = new Aro();
        if ($created) {
            // on insert
            $aro_data = array(
                'alias' => $this->data['User']['username'],
                'parent_id' => $this->data['User']['group_id'],
                'model' => 'User',
                'foreign_key' => $this->getLastInsertId(),
            );
            $aro->create();
            $aro->save($aro_data);
        } else {
            // on update
            $aro_data = $aro->findByForeignKeyAndModel($this->id, 'User');
            $aro_data['Aro']['parent_id'] = $this->data['User']['group_id'];
            $aro->id = $aro_data['Aro']['id'];
            $aro->save($aro_data);
        }
    }
    
    function beforeDelete() {
        $aro = new Aro();
        $aro_data = $aro->findByForeignKeyAndModel($this->id, 'User');
        $aro->delete($aro_data['Aro']['id']);
        return true;
    }
    
    function identicalFieldValues($field=array(), $compare_field=null) {
        foreach($field as $key => $value){
            $v1 = $value;
            $v2 = $this->data[$this->name][$compare_field];                 
            if($v1 !== $v2) {
                return false;
            } else {
                continue;
            }
        }
        return true;
    }
    
    function validatePasswordOn($status = 'create') {
        $this->validate['passwd']['password_between']['on'] = $status;
        $this->validate['passwd']['identicalFieldValues']['on'] = $status;
        $this->validate['passwd2']['identicalFieldValues']['on'] = $status;
    }

    /**
     * Generate and return a random string
     *
     * The default string returned is 8 alphanumeric characters.
     *
     * The type of string returned can be changed with the "seeds" parameter.
     * Four types are - by default - available: alpha, numeric, alphanum and hexidec. 
     *
     * If the "seeds" parameter does not match one of the above, then the string
     * supplied is used.
     *
     * @author      Aidan Lister <aidan@php.net>
     * @version     2.1.0
     * @link        http://aidanlister.com/repos/v/function.str_rand.php
     * @param       int     $length  Length of string to be generated
     * @param       string  $seeds   Seeds string should be generated from
     */
    function _str_rand($length = 32, $seeds = 'alphanum') {
        // Possible seeds
        $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
        $seedings['numeric'] = '0123456789';
        $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
        $seedings['hexidec'] = '0123456789abcdef';
        
        // Choose seed
        if (isset($seedings[$seeds]))
        {
            $seeds = $seedings[$seeds];
        }
        
        // Seed generator
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand($seed);
        
        // Generate
        $str = '';
        $seeds_count = strlen($seeds);
        
        for ($i = 0; $length > $i; $i++)
        {
            $str .= $seeds{mt_rand(0, $seeds_count - 1)};
        }
        
        return $str;
    }
}

?>