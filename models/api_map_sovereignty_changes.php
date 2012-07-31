<?php

/**
 * Model for table 'ea_map_sovereignty_changes'
 * 
 * Sovereignty of the systems
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       Primary key
 * solarSystemID                                        X       The unique identification number of a solar system. You can look up the details of the solar system in the table mapSolarSystems of the CCP Database Dump
 * action                                               X       'Gain' or 'Lost'
 * allianceID                                           X       The ID of the alliance that has sovereignty of this solar system, or 0 if nobody has sovereignty. The Alliance List provides a list of the alliances.
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author  Willi Thiel
 * @date    2010-10-03
 * @version 1.0
 */
 
class ApiMapSovereigntyChanges extends AppModel {

    // Model Attributes
    var $name               = 'ApiMapSovereigntyChanges';
    var $useDbConfig        = 'db_eveapi';
    var $useTable           = 'map_sovereignty_changes';
    var $primaryKey         = 'id';
    var $displayField       = 'solarSystemID';
    var $recursive          = -1;
    
}

?>