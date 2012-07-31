<?php

/**
 * Model for table 'eveGraphics'
 * 
 * Graphics and icons used in game.
 * 
 * Column                       Links to                    Used    Note
 * ==========================================================================================================================================================================================
 * graphicID                                                X       Unique ID of Graphics. Should be primary key.
 * url3D                                                    X       3D Image URL as in-game resource.
 * urlWeb                                                   X       Actually there is item name, not URL at all.
 * description                                              X       Description of Graphics.
 * published                                                X       1 if Graphics is published in-game.
 * obsolete                                                 X       1 if Graphics is obsolete.
 * icon                                                     X       Name of icon file.
 * urlSound                                                 X       Sound URL as in-game resource.
 * explosionID                                              X       (internal?) ID of explosion.  * 
 * 
 * @author Willi Thiel
 * @date 2010-09-03
 * @version 1.0
 */
class EveEveGraphic extends AppModel {

    // Model Attributes
    var $name               = 'EveEveGraphic';
    var $useDbConfig        = 'db_evestatic';
    var $useTable           = 'eveGraphics';
    var $primaryKey         = 'graphicID';
    var $displayField       = 'urlWeb';
    var $recursive          = 2;
    var $cacheQueries       = true;
    var $actAs              = array('Readonly');

}

?>