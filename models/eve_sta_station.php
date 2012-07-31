<?php
/**
 * Model for table 'staStations'
 * 
 * List of all stations.
 * 
 * Column           Links to                            Used    Note
 * ==========================================================================================================================================================================================
 * stationID        mapDenormalize.itemID               X   Unique ID of station. Should be primary key.
 * security                                             X   Security level of station.
 * dockingCostPerVolume                                     Cost of docking per ship volume.
 * maxShipVolumeDockable                                X   Maximum volume of ship that can dock here.
 * officeRentalCost                                     X   Cost of office rent. Should be not static data? Perhaps is base price.
 * operationID      staOperations.operationID           X   Operation mode of this station.
 * stationTypeID    staStationTypes.stationTypeID       X   typeID of station.
 * corporationID    chrNPCCorporations.corporationID    X   ID of owning corporation.
 * solarSystemID    mapSolarSystems.solarSystemID       X   Solar system where station is located.
 * constellationID  mapConstellations.constellationID   X   Constellation where station is located.
 * regionID         mapRegions.regionID                 X   Region where station is located.
 * stationName                                          X   Name of station. Also see eveNames table linked on staStations.stationID=eveNames.itemID.
 * x                                                    X   X coordinate of station, relative of Solar system center.
 * y                                                    X   Y coordinate of station, relative of Solar system center.
 * z                                                    X   Z coordinate of station, relative of Solar system center.
 * reprocessingEfficiency                               X   Reprocessing efficiency of station.
 * reprocessingStationsTake                             X   Reprocessing mineral cost of station.
 * reprocessingHangarFlag                                   Unknown.
 * capitalStation                                           Not used in static dump.
 * ownershipDateTime                                        Not used in static dump.
 * upgradeLevel                                             Not used in static dump.
 * customServiceMask                                        Not used in static dump.
 * 
 * @author  Willi Thiel
 * @date    2010-10-03
 * @version 0.1
 */
class EveStaStation extends AppModel {

    // Model Attributes
    var $name               = 'EveStaStation';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'staStations';
    var $primaryKey         = 'stationID';
    var $displayField       = 'stationName';
    var $recursive          = -1;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');
    
}
