<?php

/**
 * Model for table 'se_mineral_index_types'
 * 
 * Contains all user options.
 * 
 * Column               Links to                        Used    Note
 * ==========================================================================================================================================================================================
 * id                                                   X       id of the option.
 * eve_inv_type_id      eveInvTypes.typeID              X       The ID of the EveInvType
 * price                                                X       The price of the invtype
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-14
 * @version 1.0
 */
class MineralIndex extends AppModel {

    // Model Attributes
    var $name               = 'MineralIndex';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'mineral_indexes';
    var $primaryKey         = 'id';
    var $displayField       = 'eve_inv_type_id';
    var $recursive          = 1;
    
    var $belongsTo = array(
        'MineralIndexType' => array(
            'className'     => 'MineralIndexType',
            'foreignKey'    => 'eve_inv_type_id',
            'dependent'     => false
        ),
    ); 

}
?>