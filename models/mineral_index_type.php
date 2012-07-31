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
 * order                                                X       The order of the entries
 * created                                              X       created timestamp.
 * modified                                             X       modified timestamp.
 * 
 * @author Willi Thiel
 * @date 2010-09-14
 * @version 1.0
 */
class MineralIndexType extends AppModel {

    // Model Attributes
    var $name               = 'MineralIndexType';
    var $useDbConfig        = 'db_simpleve';
    var $useTable           = 'mineral_index_types';
    var $primaryKey         = 'eve_inv_type_id';
    var $displayField       = 'eve_inv_type_id';
    var $recursive          = 3;
    
    var $hasOne = array(
        'EveInvType' => array(
            'className'     => 'EveInvType',
            'foreignKey'    => 'typeID',
            'dependent'     => false
        ),
    ); 
    
    var $hasMany = array(
        'MineralIndex' => array(
            'className'     => 'MineralIndex',
            'foreignKey'    => 'eve_inv_type_id',
            'dependent'     => false,
//            'conditions'    => array('MineralIndex.created >= DATE_ADD(NOW(), INTERVAL -2 DAY)'),
            'limit'         => 2,
            'order'         => array('MineralIndex.created DESC')
        ),
    ); 
}
?>