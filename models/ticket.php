<?php

/**
 * Model for table 'se_tickets'
 * 
 * Contains all tickets.
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the ticket.
 * user_id              User.id                         X       id of the user that ticket belongs to
 * hash                                                 X       unique hash that matches an url
 * action                                               X       the action to perform (e.g. 'activate', 'newpasswd')
 * closed                                               X       1 if the ticket has already been closed/used
 * expires                                              X       timestamp until the ticket is valid
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-08
 * @version 1.0
 */
class Ticket extends AppModel {

    // Model Attributes
    var $name               = 'Ticket';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'tickets';
    var $primaryKey         = 'id';
    var $displayField       = 'hash';
    var $recursive          = 1;
    
    var $validate = array(
        'hash' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'on' => 'create',
                'message' => 'This hash has already been taken.'
            ),
        ),
        'action' => array(
            'rule' => 'notEmpty',
            'message' => 'Action cannot be left blank'
        )
    );

    var $belongsTo = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'user_id',
            'dependent'     => false
        ),
    ); 

    function beforeSave() {
        if (empty($this->data['Ticket']['hash'])) {
            $this->data['Ticket']['hash'] = $this->_str_rand();
        }
        return true;
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