<?php

/**
 * Model for table 'ramActivities'
 * 
 * Research and Manufacturing Activities
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * activityID                                           X   Unique ID of the activity.
 * activityName                                         X   Name of the activity (e.g. Manufacturing, Copying, Reverse Engineering).
 * iconNo                                               X   
 * description                                          X   Text description of the activity.
 * published                                            X   1 means the activity has been published and is available in game. 0 means it is not available.
 * 
 * @author  Willi Thiel
 * @date    2010-09-03
 * @version 0.1
 */
class EveRamActivity extends AppModel {

    // Model Attributes
    var $name               = 'EveRamActivity';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'ramActivities';
    var $primaryKey         = 'activityID';
    var $displayField       = 'activityName';
    var $recursive          = 2;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

    // Associations
/*    var $hasMany = array(
        'EveRamTypeRequirement' => array(
            'className'     => 'EveRamTypeRequirement',
            'foreignKey'    => 'activityID',
            'dependent'     => false
        )
    ); */
    public function toArray() {
        $result = array();
        $eveRamActivities = $this->find('all');
        foreach ($eveRamActivities as $eveRamActivity) {
            $result[$eveRamActivity['EveRamActivity']['activityID']]['activityName'] = $eveRamActivity['EveRamActivity']['activityName'];
            $result[$eveRamActivity['EveRamActivity']['activityID']]['iconNo'] = $eveRamActivity['EveRamActivity']['iconNo'];
        }
        return $result;
    }
    
}

?>