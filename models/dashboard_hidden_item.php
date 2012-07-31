<?php

/**
 * Model for table 'se_dashboard_hidden_items'
 * 
 * Contains all hidden items
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the entry.
 * type                                                 X       Type of the dashboard entry 
 * character_id                                         X       ID of character of the dashboard entry. 
 * api_id                                               X       Unique ID of the api-record of the dashboard entry
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-10-09
 * @version 1.0
 */
class DashboardHiddenItem extends AppModel {

    // Model Attributes
    var $name               = 'DashboardHiddenItem';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'dashboard_hidden_items';
    var $primaryKey         = 'id';
    var $displayField       = 'character_id';
    var $recursive          = -1;
    
}
?>