<?php

/**
 * Model for table 'ea_eve_alliance_list'
 * 
 * Alliances
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       Primary key
 * allianceID                                           X       ID number of the alliance.
 * name                                                 X       Name of the alliance.
 * shortName                                            X       Alliance ticker.
 * executorCorpID                                       X       Corporation ID of the executor corporation.
 * memberCount                                          X       Number of pilots in the alliance.
 * startDate                                            X       Date the alliance was founded. 
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author  Willi Thiel
 * @date    2010-10-03
 * @version 1.0
 */
 
class ApiEveAllianceList extends AppModel {

    // Model Attributes
    var $name               = 'ApiEveAllianceList';
    var $useDbConfig        = 'db_eveapi';
    var $useTable           = 'eve_alliance_list';
    var $primaryKey         = 'id';
    var $displayField       = 'name';
    var $recursive          = -1;
    
}

?>