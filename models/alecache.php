<?php

/**
 * Model for table 'se_alecache'
 * 
 * Managed by AleAPI
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * host                                                 X       The hostname of the query
 * path                                                 X       The path of the query
 * params                                               X       params of the query (sha1(http_build_query($params, '', '&')));
 * content                                              X       The result of the query
 * cachedUntil                                          X       Datetime until this result is cached
 * 
 * @author Willi Thiel
 * @date 2010-10-01
 * @version 1.0
 */
class Alecache extends AppModel {

    // Model Attributes
    var $name               = 'Alecache';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'alecache';
    var $primaryKey         = 'params';
    var $displayField       = 'content';
    var $recursive          = -1;
    
}

?>