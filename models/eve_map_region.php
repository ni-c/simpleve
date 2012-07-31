<?php
/**
 * Model for table 'mapRegions'
 * 
 * List of regions
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * regionID                                             X   Unique ID of region. Should be primary key.
 * regionName                                           X   Name of region. Also see eveNames table linked on eveNames.itemID=mapRegions.regionID.
 * x                                                    X   Absolute coordinate X of region's center.
 * y                                                    X   Absolute coordinate Y of region's center.
 * z                                                    X   Absolute coordinate Z of region's center.
 * xMin                                                 X   Minimal value of X coordinate.
 * xMax                                                 X   Maximal value of X coordinate.
 * yMin                                                 X   Minimal value of Y coordinate.
 * yMax                                                 X   Maximal value of Y coordinate.
 * zMin                                                 X   Maximal value of Z coordinate.
 * zMax                                                 X   Maximal value of Z coordinate.
 * factionID        chrFactions.factionID               X   ID of controlling faction.
 * radius                                               X   Radius of region.
 * 
 * @author  Willi Thiel
 * @date    2010-09-19
 * @version 0.1
 */
class EveMapRegion extends AppModel {

    // Model Attributes
    var $name               = 'EveMapRegion';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'mapRegions';
    var $primaryKey         = 'regionID';
    var $displayField       = 'regionName';
    var $recursive          = -1;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');
    
}
?>