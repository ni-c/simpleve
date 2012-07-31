<?php
/**
 * Model for table 'mapSolarSystems'
 * 
 * List of solar systems.
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * regionID         mapRegions.regionID                 X       ID of region.
 * constellationID  mapConstellations.constellationID   X       ID of constellation.
 * solarSystemID                                        X       Unique ID of solar system. Should be primary key.
 * solarSystemName                                      X       Name of solar system. Also see eveNames table linked on eveNames.itemID=mapSolarSystems.solarSystemID.
 * x                                                    X       Absolute coordinate X of solar system's center.
 * y                                                    X       Absolute coordinate Y of solar system's center.
 * z                                                    X       Absolute coordinate Z of solar system's center.
 * xMin                                                 X       Minimal value of X coordinate.
 * xMax                                                 X       Maximal value of X coordinate.
 * yMin                                                 X       Minimal value of Y coordinate.
 * yMax                                                 X       Maximal value of Y coordinate.
 * zMin                                                 X       Minimal value of Z coordinate.
 * zMax                                                 X       Maximal value of Z coordinate.
 * luminosity                                           X       Star luminousity. Also see mapCelestialStatistics table.
 * border                                                       1 if solar system is on border.
 * fringe                                                       1 if solar system is in fringe, i.e. have only one link.
 * corridor                                                     1 if solar system is corridor, i.e have 2 links.
 * hub                                                          1 if solar system is hub, i.e. have 3 or more links.
 * international                                                1 if solar system have stations of different factions. (note: there are a number of systems that are marked as international but only have 1 or no stations at all)
 * regional                                                     1 if solar system have interregional link.
 * constellation                                                1 if solar system have interconstellational link.
 * security                                             X       Security level of system.
 * factionID        chrFactions.factionID               X       ID of controlling faction. Note: Only set if the systems faction differs from the rest of the constellation.
 * radius                                               X       Radius of solar system.
 * sunTypeID        invTypes.typeID                     X       typeID of star in center of solar system.
 * securityClass                                        X       Security class of system. Used to determine available minerals, see mapSolarSystemMinerals and mapSolarSystemOreBySecurityClass tables (not included in dump).
 * allianceID                                                   Sovereign alliance. Not used in static dump.
 * sovereigntyLevel                                             Level of sovereignity. Not used in static dump.
 * sovereigntyDateTime                                          Date of sovereignity start. Not used in static dump.
 * 
 * @author  Willi Thiel
 * @date    2010-09-19
 * @version 0.1
 */
class EveMapSolarSystem extends AppModel {

    // Model Attributes
    var $name               = 'EveMapSolarSystem';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'mapSolarSystems';
    var $primaryKey         = 'solarSystemID';
    var $displayField       = 'solarSystemName';
    var $recursive          = -1;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');
    
}
