<?php

/**
 * Model for table 'ea_map_sovereignty'
 * 
 * Sovereignty of the systems
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       Primary key
 * solarSystemID                                        X       The unique identification number of a solar system. You can look up the details of the solar system in the table mapSolarSystems of the CCP Database Dump
 * allianceID                                           X       The ID of the alliance that has sovereignty of this solar system, or 0 if nobody has sovereignty. The Alliance List provides a list of the alliances.
 * corporationID                                        X       The ID of the corporation that owns the Territorial Claim Unit (TCU) if there is one in the system.
 * factionID                                            X       The NPC Faction controlling the system. The CCP Database Dump has a table with the faction names.
 * solarSystemName                                      X       The name of the solar system. 
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author  Willi Thiel
 * @date    2010-10-03
 * @version 1.0
 */
 
class ApiMapSovereignty extends AppModel {

    // Model Attributes
    var $name               = 'ApiMapSovereignty';
    var $useDbConfig        = 'db_eveapi';
    var $useTable           = 'map_sovereignty';
    var $primaryKey         = 'id';
    var $displayField       = 'solarSystemID';
    var $recursive          = -1;
    
}

?>