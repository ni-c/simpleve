<?php

/**
 * Model for table 'se_subscription_journal'
 * 
 * Contains all donations for subscriptions
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the wallet entry.
 * ref_id                                               X       ID of transaction. Guaranteed to be unique with this page call; Was previously subject to renumbering periodically to remain within the limit of a 32bit integer [1]. As of 10/01/2010 the values of refID being seen have exceeded this limit, indicating that CCP have upgraded this field to a bigint (64bit integer), removing the need for further renumbering. Use the last listed refID with the beforeRefID argument to walk the list. 
 * character_id                                         X       ID of chararcter in the transaction. 
 * character_name                                       X       Name of chararcter in the transaction.
 * reason                                               X       user-entered text.
 * amount                                               X       The amount transferred between parties (if this shows up in the in-game wallet as green, the number is positive; if red, then negative). 
 * timestamp                                            X       Date & time of the transaction.
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-08
 * @version 1.0
 */
class SubscriptionJournal extends AppModel {

    // Model Attributes
    var $name               = 'SubscriptionJournal';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'subscription_journals';
    var $primaryKey         = 'id';
    var $displayField       = 'character_name';
    var $recursive          = -1;
    
    var $validate = array(
        'ref_id' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'on' => 'create',
                'message' => 'This ref_id has already been taken.'
            ),
        ),
    );
}
?>