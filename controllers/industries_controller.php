<?php

/**
 * Controller for the EveInvType model.
 * 
 * @author Willi Thiel
 * @date 2010-09-02
 * @version 0.2
 */
class IndustriesController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Industries';
    
    /**
     * An array containing the class names of models this controller uses.
     *
     * - EveInvType 
     * - EveInvTypeMaterial 
     */
    var $uses = array(
        'EveInvType', 
        'EveInvTypeMaterial', 
        'EveDgmTypeAttribute', 
        'EveInvMetaType',
        'EveMapRegion',
        'EveInvBlueprintType',
        'Alecache'
    );
    
    var $title_for_layout = 'Industry';
    
    function beforeFilter() {
        $this->Auth->mapActions(
            array(
                'read' => array(
                    'item_view', 
                    'item_search',
                    'refiningcalculator'
                ),
            )
        );
        parent::beforeFilter();
    }

    function index() {
        
    }
    
    function refiningcalculator($priceregion = null) {
        
        $data = array();
        
        $data[0] = array(
            'oreSkill' => 'Veldspar processing',
            'refineSize' => 333,
            'Ores' => array(
                array(
                    'name' => 'Veldspar',
                    'result' => array(
                        0 => array('value' => 1000)
                    )
                ),
                array(
                    'name' => 'Concentrated Veldspar',
                    'result' => array(
                        0 => array('value' => 1050)
                    )
                ),
                array(
                    'name' => 'Dense Veldspar',
                    'result' => array(
                        0 => array('value' => 1100)
                    )
                ),
            )
        );
        
        $data[1] = array(
            'oreSkill' => 'Scordite processing',
            'refineSize' => 333,
            'Ores' => array(
                array(
                    'name' => 'Scordite',
                    'result' => array(
                        0 => array('value' => 833),
                        1 => array('value' => 416)
                    )
                ),
                array(
                    'name' => 'Condensed Scordite',
                    'result' => array(
                        0 => array('value' => 875),
                        1 => array('value' => 437)
                    )
                ),
                array(
                    'name' => 'Massive Scordite',
                    'result' => array(
                        0 => array('value' => 916),
                        1 => array('value' => 458)
                    )
                ),
            )
        );
        
        $data[2] = array(
            'oreSkill' => 'Plagioclase processing',
            'refineSize' => 333,
            'Ores' => array(
                array(
                    'name' => 'Plagioclase',
                    'result' => array(
                        0 => array('value' => 256),
                        1 => array('value' => 512),
                        2 => array('value' => 256)
                    )
                ),
                array(
                    'name' => 'Azure Plagioclase',
                    'result' => array(
                        0 => array('value' => 269),
                        1 => array('value' => 538),
                        2 => array('value' => 269)
                    )
                ),
                array(
                    'name' => 'Rich Plagioclase',
                    'result' => array(
                        0 => array('value' => 282),
                        1 => array('value' => 569),
                        2 => array('value' => 282)
                    )
                ),
            )
        );
        
        $data[3] = array(
            'oreSkill' => 'Kernite processing',
            'refineSize' => 400,
            'Ores' => array(
                array(
                    'name' => 'Kernite',
                    'result' => array(
                        0 => array('value' => 386),
                        2 => array('value' => 773),
                        3 => array('value' => 386)
                    )
                ),
                array(
                    'name' => 'Luminous Kernite',
                    'result' => array(
                        0 => array('value' => 405),
                        2 => array('value' => 812),
                        3 => array('value' => 405)
                    )
                ),
                array(
                    'name' => 'Fiery Kernite',
                    'result' => array(
                        0 => array('value' => 424),
                        2 => array('value' => 850),
                        3 => array('value' => 424)
                    )
                ),
            )
        );
        
        $data[4] = array(
            'oreSkill' => 'Pyroxeres processing',
            'refineSize' => 333,
            'Ores' => array(
                array(
                    'name' => 'Pyroxeres',
                    'result' => array(
                        0 => array('value' => 844),
                        1 => array('value' => 59),
                        2 => array('value' => 120),
                        4 => array('value' => 11)
                    )
                ),
                array(
                    'name' => 'Solid Pyroxeres',
                    'result' => array(
                        0 => array('value' => 886),
                        1 => array('value' => 62),
                        2 => array('value' => 126),
                        4 => array('value' => 12)
                    )
                ),
                array(
                    'name' => 'Viscous Pyroxeres',
                    'result' => array(
                        0 => array('value' => 928),
                        1 => array('value' => 65),
                        2 => array('value' => 133),
                        4 => array('value' => 13)
                    )
                ),
            )
        );
        
        $data[5] = array(
            'oreSkill' => 'Omber processing',
            'refineSize' => 500,
            'Ores' => array(
                array(
                    'name' => 'Omber',
                    'result' => array(
                        0 => array('value' => 307),
                        1 => array('value' => 123),
                        3 => array('value' => 307)
                    )
                ),
                array(
                    'name' => 'Silvery Omber',
                    'result' => array(
                        0 => array('value' => 322),
                        1 => array('value' => 129),
                        3 => array('value' => 322)
                    )
                ),
                array(
                    'name' => 'Golden Omber',
                    'result' => array(
                        0 => array('value' => 338),
                        1 => array('value' => 135),
                        3 => array('value' => 338)
                    )
                ),
            )
        );
        
        $data[6] = array(
            'oreSkill' => 'Jaspet processing',
            'refineSize' => 500,
            'Ores' => array(
                array(
                    'name' => 'Jaspet',
                    'result' => array(
                        0 => array('value' => 259),
                        1 => array('value' => 259),
                        2 => array('value' => 518),
                        4 => array('value' => 259),
                        5 => array('value' => 8),
                    )
                ),
                array(
                    'name' => 'Pure Jaspet',
                    'result' => array(
                        0 => array('value' => 272),
                        1 => array('value' => 272),
                        2 => array('value' => 544),
                        4 => array('value' => 272),
                        5 => array('value' => 8),
                    )
                ),
                array(
                    'name' => 'Pristine Jaspet',
                    'result' => array(
                        0 => array('value' => 285),
                        1 => array('value' => 285),
                        2 => array('value' => 570),
                        4 => array('value' => 285),
                        5 => array('value' => 9),
                    )
                ),
            )
        );
        
        $this->set('Regions', $this->_getRegions());
        $this->set('priceregion', $this->_checkCurrentRegion($priceregion, 0));
        $this->set('orelist', $data);
    }
    
    /**
     * Views the item with the given ID
     */
    function item_view($id = 34 /* 34 = Tritanium */, $priceregion = null) {
        
        $EveInvTypes = $this->_getInvTypes($id, 12);
        
        // We have a bluebrint here
        if ($EveInvTypes['EveInvGroup']['EveInvCategory']['categoryID']==9) {
            $EveInvBlueprintType = $this->EveInvBlueprintType->find('first', array('conditions' => array('EveInvBlueprintType.blueprintTypeID' =>$id)));
            $id = $EveInvBlueprintType['EveInvBlueprintType']['productTypeID'];
            $url = '/industry/manufacturingcalculator/' . $id;
            if ($priceregion!=null) {
                $url = $url . '/' .$priceregion;
            }
            $this->redirect($url);
        }
        
        // Lets set our priceregion
        $priceregion = $this->_checkCurrentRegion($priceregion);

        // If we don't have cached prices, create pricelist
        if (!isset($this->data) || ($this->data['Industry']['cached']!=1)) {
            // Prices are not cached
            if ((isset($this->options['marketdetails'])) && ($this->options['marketdetails']==1)) {
                $priceregions = array(10000002, 10000043, 10000030, 10000032, $priceregion);
            } else {
                $priceregions = array($priceregion);
            }
            $pricelist = array();
            $this->_createPriceList($EveInvTypes, $priceregions, 'buy', $pricelist);
            $this->_removeCachedPrices($pricelist);
        }
        
        // If we have cached prices, show the stuff
        if ((isset($this->data) && ($this->data['Industry']['cached']==1)) || (sizeof($pricelist)==0)) {
            // Prices are cached

            $MaterialList = array();
            $this->_createMaterialList($EveInvTypes['EveInvTypeMaterial'], $MaterialList);
            $this->_createMaterialList($EveInvTypes['EveRamTypeRequirement'], $MaterialList);
            if (isset($EveInvTypes['Product_EveInvBlueprintType']['Blueprint_EveInvType']['EveRamTypeRequirement'])) {
                $this->_createMaterialList($EveInvTypes['Product_EveInvBlueprintType']['Blueprint_EveInvType']['EveRamTypeRequirement'], $MaterialList);
            }
            
            $this->_calculate($EveInvTypes);
            $this->set('MaterialList', $MaterialList);
            $this->set('EveInvTypes', $EveInvTypes);
            $this->set('Decryptors', $this->_getDecryptors($EveInvTypes['EveInvType']['raceID']));
            $this->set('Invention', $this->_getInvention($EveInvTypes));
            $this->set('MetaTypes', $this->_getMetaTypes($EveInvTypes));
            $this->set('priceregion', $priceregion);
            $this->set('Regions', $this->_getRegions());
        } else {
            $this->set('pricelist', $pricelist);
            $this->set('id', $id);
            $this->set('region', $priceregion);
            $this->render('/industries/load_prices');
        }
    }

    function item_search() {
        
        if (isset($this->data)) {
            $this->EveInvType->unbindModel(
                array(
                    'hasOne' => array('Product_EveInvBlueprintType'),
                    'hasMany' => array('EveInvTypeMaterial', 'EveRamTypeRequirement'),
                    'belongsTo' => array('EveInvMetaType'),
                )
            );
            $this->EveInvType->EveInvGroup->unbindModel(
                array(
                    'hasMany' => array('EveInvType'),
                    'belongsTo' => array('EveGraphic'),
                )
            );
            $this->EveInvType->EveInvGroup->EveInvCategory->unbindModel(
                array(
                    'hasMany' => array('EveInvGroup')
                )
            );
            $this->EveInvType->recursive = 3;
            $EveInvTypes = $this->EveInvType->find('all', 
                array(
                    'conditions' => 
                        array(
                            'EveInvType.typeName LIKE' => '%' . $this->data['EveInvType']['typeName'] . '%',
                            'EveInvGroup.categoryID' => array('4','6','7','8','17','18','22','23','32'),
                            'EveInvType.published' => 1,
                            'EveInvType.marketGroupID >=' => 0,
                        ),
                    'order'=>array('EveInvType.typeName ASC'),
                )
            );
            
            if (count($EveInvTypes)==1) {
                $this->redirect('/industry/manufacturingcalculator/' . $EveInvTypes[0]['EveInvType']['typeID']);
            } else {
                $this->set('EveInvTypes', $EveInvTypes);
            }
        }
    }

    private function _getRegions() {
        return $this->EveMapRegion->find('all', 
            array(
                'conditions' => array(
                    'EveMapRegion.factionID !=' => null,
                ),
                'order' => array(
                    'EveMapRegion.regionName ASC'
                )
            )
        );
    }

    private function _checkCurrentRegion($priceregion, $default = 'custom') {
        if (($priceregion == null) || ($priceregion == 'eve')) {
            if (isset($this->igbInfo['regionName']) && ($this->igbInfo['regionName']!='')) {
                $mapRegion = $this->EveMapRegion->find('first', array('conditions' => array('EveMapRegion.regionName' => $this->igbInfo['regionName'])));
                $priceregion = $mapRegion['EveMapRegion']['regionID'];
            } else {
                if (isset($this->options['priceregion'])) {
                    $priceregion = $this->options['priceregion'];
                } else {
                    $priceregion = $default;
                }
            }         
        }
        $this->Options->set('priceregion', $priceregion);
        return $priceregion;
    }

    private function _getInvention($EveInvTypes) {

        App::import('Helper', 'CharacterXml');
        $characterXml = new CharacterXmlHelper();
    
        // Has a metatype to invent
        if ((isset($EveInvTypes['EveInvMetaType'])) && (count($EveInvTypes['EveInvMetaType'])>0) && (isset($EveInvTypes['EveInvMetaType']['ParentEveInvType'])) && (isset($EveInvTypes['EveInvMetaType']['ParentEveInvType']['Product_EveInvBlueprintType']))) {
            $blueprint = $EveInvTypes['EveInvMetaType']['ParentEveInvType']['Product_EveInvBlueprintType'];
            $item = $EveInvTypes['EveInvMetaType']['ParentEveInvType'];
            $group = $EveInvTypes['EveInvMetaType']['ParentEveInvType']['EveInvGroup'];
        } else {
            $blueprint = $EveInvTypes['Product_EveInvBlueprintType'];
            $item = $EveInvTypes['EveInvType'];
            $group = $EveInvTypes['EveInvGroup'];
        }
        
        $Invention = array();
        switch ($item['groupID']) {
            case 27: // Battleship
            case 419: // Battlecruiser
                $base_chance = 0.2;
                break;
            case 26: // Cruiser
            case 28: // Industrial
                $base_chance = 0.25;
                break;
            case 25: // Frigate
            case 420: // Destroyer
            case 513: // Freighter
                $base_chance = 0.3;
                break;
            default:
                $base_chance = 0.4;
                break;
        }
        switch ($item['typeID']) {
            case 22544: // Hulk
            case 17476: // Covetor
                $base_chance = 0.2;
                break;
            case 22548: // Mackinaw
            case 17478: // Retriever
                $base_chance = 0.25;
                break;
            case 22546: // Skiff
            case 17480: // Procurer
                $base_chance = 0.3;
                break;
            default:
                // Nothing
                break;
        }

        if (isset($blueprint['Blueprint_EveInvType'])) {
            foreach($blueprint['Blueprint_EveInvType']['EveRamTypeRequirement'] as $EveRamTypeRequirement) {
                if ($EveRamTypeRequirement['EveRamActivity']['activityID'] == 8) {
                    if ($EveRamTypeRequirement['EveInvType']['groupID'] == 333 /* Decryptor */) {
                        $tmp = $this->EveDbTool->getRequiredSkills($EveRamTypeRequirement['EveInvType']['typeID']);
                        $datacore_skill[] = $tmp[1];  
                    }
                    if ($EveRamTypeRequirement['EveInvType']['groupID'] == 716 /* Encryption Skill */) {
                        $tmp = $this->EveDbTool->getRequiredSkills($EveRamTypeRequirement['EveInvType']['typeID']);
                        $encryption_skill = $tmp[1]; 
                        
                    }
                }
            }
            if ($group['EveInvCategory']['categoryID']==6) {
                // Ship
                $Invention['base_runs'] = 1;
            } else {
                $Invention['base_runs'] = 10;
            }
            
            $Invention['base_me'] = -4;
            $Invention['base_pe'] = -4;
            $Invention['base_chance'] = $base_chance;
            if (isset($encryption_skill)) {
                $Invention['encryption_skill_level'] = $characterXml->getSkillLevel($this->active_character, $encryption_skill['skill_id']);
                $Invention['datacore_1_skill_level'] = $characterXml->getSkillLevel($this->active_character, $datacore_skill[0]['skill_id']);
                $Invention['datacore_2_skill_level'] = $characterXml->getSkillLevel($this->active_character, $datacore_skill[1]['skill_id']);
            } else {
                $Invention['encryption_skill_level'] = 0;
                $Invention['datacore_1_skill_level'] = 0;
                $Invention['datacore_2_skill_level'] = 0;
            }
        }
        return $Invention;
    }

    private function _getMetaTypes($EveInvTypes) {
        
        if ((isset($EveInvTypes['EveInvMetaType'])) && (count($EveInvTypes['EveInvMetaType'])>0) && (isset($EveInvTypes['EveInvMetaType']['ParentEveInvType'])) && (isset($EveInvTypes['EveInvMetaType']['ParentEveInvType']['Product_EveInvBlueprintType']))) {
            $id = $EveInvTypes['EveInvMetaType']['ParentEveInvType']['typeID'];
        } else {
            $id = $EveInvTypes['EveInvType']['typeID'];
        }

        $this->EveInvMetaType->bindModel(
            array(
                'hasMany' => array(
                    'EveDgmTypeAttribute' => array(
                        'className' => 'EveDgmTypeAttribute',
                        'foreignKey' => 'typeID',
                        'conditions' => array('EveDgmTypeAttribute.attributeID' => 633),
                    )
                )
            )
        );
        $this->EveInvMetaType->EveInvType->EveInvGroup->unbindModel(array('hasMany' => array('EveInvType')));
        $this->EveInvMetaType->EveInvType->unbindModel(array('hasMany' => array('EveInvTypeMaterial')));
        $this->EveInvMetaType->EveInvType->unbindModel(array('belongsTo' => array('EveInvMetaType')));
        $this->EveInvMetaType->unbindModel(array('belongsTo' => array('ParentEveInvType')));
        $this->EveInvMetaType->recursive = 3;
        $result = $this->EveInvMetaType->find('all', 
            array(
                'conditions' => 
                    array(
                        'EveInvMetaType.parentTypeID' => $id,
                        'EveInvMetaType.metaGroupID' => 1,
                    )
                )
            );
        return $result;
    }

    private function _getInvTypes($id, $recursion) {
        
        $this->EveInvType->EveInvGroup->unbindModel(array('hasMany' => array('EveInvType')));
        $this->EveInvType->EveInvGroup->EveInvCategory->unbindModel(array('hasMany' => array('EveInvGroup')));
        $this->EveInvType->recursive = 12;
        $EveInvTypes = $this->EveInvType->find('first', array('conditions' => array('EveInvType.typeID' => $id)));
        return $EveInvTypes;
    }

    private function _getDecryptors($race_id) {
        
        switch($race_id) {
            case 1: // Caldari
                $group_id = 731;
                break;
            case 2: // Minmatar
                $group_id = 729;
                break;
            case 4: // Amarr
                $group_id = 728;
                break;
            case 8: // Gallente
                $group_id = 730;
                break;
            default:
                $group_id = 730;
                break;
        }
        $this->EveInvType->unbindModel(array('belongsTo' => array('EveInvMetaType')));
        $this->EveInvType->unbindModel(array('hasOne' => array('Product_EveInvBlueprintType')));
        $this->EveInvType->unbindModel(array('hasMany' => array('EveInvTypeMaterial')));
        $this->EveInvType->unbindModel(array('hasMany' => array('EveRamTypeRequirement')));
        $this->EveInvType->EveInvGroup->unbindModel(array('hasMany' => array('EveInvType')));
        $this->EveInvType->recursive = 2;
        $Decryptors = $this->EveInvType->find('all', array('conditions' => array('EveInvType.groupID' => $group_id)));
        foreach ($Decryptors as &$decryptor) {
            $description = $decryptor['EveInvType']['description'];
            $decryptor['probabilityMultiplier'] = $this->_extract('Probability Multiplier: ', $description);
            if ($decryptor['probabilityMultiplier']==0) {
                $decryptor['probabilityMultiplier'] = '1.0';
            }
            $decryptor['maxRunModifier'] = $this->_extract('Max. Run Modifier: ', $description);
            $decryptor['mineralEfficiencyModifier'] = $this->_extract('Mineral Efficiency Modifier: ', $description);
            $decryptor['productionEfficiencyModifier'] = $this->_extract('Production Efficiency Modifier: ', $description);
        }
        return $Decryptors;
    }

    private function _extract($part, $description) {
        
        $tmp = split($part, $description);
        $tmp = split('<br', $tmp[1]);
        $tmp = trim($tmp[0]);
        $tmp = str_replace('+', '', $tmp);
        $tmp = str_replace('N/A', '0', $tmp);
        if (stripos($tmp, '%')) {
            $tmp = str_replace('%', '', $tmp);
            $tmp = $tmp / 100;
            $tmp = $tmp + 1;
        }
        return $tmp;
    }

    private function _calculate(&$type) {
        
        $this->_setTechLevel($type);
        $this->_calcTech2Materials($type);
        $this->_calcWasteFactor($type);
        $this->_calcPerfectME($type);
        $this->_calcPELevel($type);
        
         foreach ($type as &$t) {
             if (is_array($t)) {
                 $this->_calculate($t);
             }
         }
    }
    
    private function _setTechLevel(&$type) {
        
        if ($this->_checkArray($type, 'Product_EveInvBlueprintType')) {
            if (count($type['EveInvMetaType'])==0) {
               $type['Product_EveInvBlueprintType']['techLevel'] = 1;
            } else {
                if (($this->_checkArray($type, 'EveInvMetaType')) &&
                    ($type['EveInvMetaType']['typeID'] == '')) {
                   $type['Product_EveInvBlueprintType']['techLevel'] = 1; 
                }
            }
        }
    }

    private function _calcTech2Materials(&$type) {
        
        if (($this->_checkArray($type, 'Product_EveInvBlueprintType')) && 
            ($this->_checkArray($type, 'EveInvTypeMaterial')) &&
            ($this->_checkArray($type, 'EveInvType')) &&
            ($this->_checkArray($type, 'EveInvMetaType')) &&
            ($this->_checkArray($type['EveInvMetaType'], 'ParentEveInvType')) &&
            ($this->_checkArray($type['EveInvMetaType']['ParentEveInvType'], 'EveInvTypeMaterial'))) {
                
            if ($type['Product_EveInvBlueprintType']['techLevel']==2) {
                foreach ($type['EveInvMetaType']['ParentEveInvType']['EveInvTypeMaterial'] as &$EveInvMetaTypeMaterial) {
                    if ($type['EveInvMetaType']['ParentEveInvType']['typeID'] != $type['EveInvType']['typeID']) {
                        $type_id = $EveInvMetaTypeMaterial['materialTypeID']; 
                        foreach ($type['EveInvTypeMaterial'] as $key => &$EveInvTypeMaterial) {                            
                            if ($EveInvTypeMaterial['materialTypeID']==$type_id) {
                                $EveInvTypeMaterial['quantity'] = $EveInvTypeMaterial['quantity'] - $EveInvMetaTypeMaterial['quantity'];
                                if ($EveInvTypeMaterial['quantity']<0) {
                                    $EveInvTypeMaterial['quantity']=0;
                                }
                                if ($EveInvTypeMaterial['quantity']==0) {
                                    unset($type['EveInvTypeMaterial'][$key]);
                                }
                            }
                        }
                    } 
                }
            }
            
        }        
    }

    private function _calcPerfectME(&$type) {
        
        $highest_quantity = 0;
        $wasteFactor = 0.1;
        if (($this->_checkArray($type, 'Product_EveInvBlueprintType')) && 
            ($this->_checkArray($type, 'EveInvTypeMaterial'))) {
            foreach ($type['EveInvTypeMaterial'] as $EveInvTypeMaterial) {
                if ($EveInvTypeMaterial['quantity']>$highest_quantity) {
                    $highest_quantity = $EveInvTypeMaterial['quantity'];
                }
            }
            if (isset($type['Product_EveInvBlueprintType']['wasteFactor'])) {
                $wasteFactor = $type['Product_EveInvBlueprintType']['wasteFactor'] / 100;
            }
            $type['Product_EveInvBlueprintType']['perfect_me'] = floor(2*$highest_quantity*$wasteFactor);
        }
            
        if (($this->_checkArray($type, 'Product_EveInvBlueprintType')) && 
            ($this->_checkArray($type, 'EveInvTypeMaterial'))) {
            foreach ($type['EveInvTypeMaterial'] as $EveInvTypeMaterial) {
                if ($EveInvTypeMaterial['quantity']>$highest_quantity) {
                    $highest_quantity = $EveInvTypeMaterial['quantity'];
                }
            }
            if (isset($type['Product_EveInvBlueprintType']['wasteFactor'])) {
                $wasteFactor = $type['Product_EveInvBlueprintType']['wasteFactor'] / 100;
            }
            $type['Product_EveInvBlueprintType']['perfect_me'] = floor(2*$highest_quantity*$wasteFactor);
        }
    }

    private function _calcPELevel(&$type) {
        
        if (($this->_checkArray($type, 'Product_EveInvBlueprintType'))) {
            $pes = array(1,2,3,4,5,10,25,50,100);
            foreach ($pes as $pe) {
                $type['Product_EveInvBlueprintType']['pe' . $pe . '_productionTime'] = $this->EveCalc->productivityTime(
                    $type['Product_EveInvBlueprintType']['productionTime'],
                    $type['Product_EveInvBlueprintType']['productivityModifier'],
                    $pe);
            }
           if ($type['Product_EveInvBlueprintType']['techLevel']==2) {
                $type['Product_EveInvBlueprintType']['pe_m4_productionTime'] = $this->EveCalc->productivityTime(
                    $type['Product_EveInvBlueprintType']['productionTime'],
                    $type['Product_EveInvBlueprintType']['productivityModifier'],
                    -4);
           }
        }
    }

    private function _calcWasteFactor(&$type) {
        
        $wasteFactor = 1;
        
        App::import('Helper', 'CharacterXml');
        $characterXml = new CharacterXmlHelper();
        
        if (($this->_checkArray($type, 'Product_EveInvBlueprintType')) && 
            ($this->_checkArray($type, 'EveInvTypeMaterial'))) {
            if (isset($type['Product_EveInvBlueprintType']['wasteFactor'])) {
                $wasteFactor = $type['Product_EveInvBlueprintType']['wasteFactor'] / 100 + 1;
            }
            foreach($type['EveInvTypeMaterial'] as &$EveInvTypeMaterial) {
                $EveInvTypeMaterial['waste_quantity'] = round($EveInvTypeMaterial['quantity'] * $wasteFactor);
                $EveInvTypeMaterial['waste'] = $wasteFactor;
                if ($type['Product_EveInvBlueprintType']['techLevel']==2) {
                    $EveInvTypeMaterial['default_quantity'] = round($this->EveCalc->materialEfficience(-4, $EveInvTypeMaterial['quantity']));
                    $EveInvTypeMaterial['your_quantity'] = round($this->EveCalc->materialEfficience(-4, $EveInvTypeMaterial['quantity'], $characterXml->getSkillLevel($this->active_character, 3388)));
                } else {
                    $EveInvTypeMaterial['default_quantity'] = $EveInvTypeMaterial['waste_quantity'];
                    $EveInvTypeMaterial['your_quantity'] = round($this->EveCalc->materialEfficience(0, $EveInvTypeMaterial['quantity'], $characterXml->getSkillLevel($this->active_character, 3388)));
                }
            }
        }
    }

    private function _checkArray($array, $key) {
        
        return (isset($array[$key])) && (count($array[$key])>0);
    }
    
    private function _createPriceList($elements, $regions, $type, &$pricelist) {
        
        foreach($elements as $element) {
            if ((is_array($element)) && (isset($element['typeID']))) {
                foreach ($regions as $region) {
                    if (!array_key_exists($element['typeID'] . '_' . $region . '_' . $type, $pricelist)) {
                        $pricelist[$element['typeID'] . '_' . $region . '_' . $type] = array(
                            'typeID'   => $element['typeID'],
                            'region'   => $region,
                            'type'     => $type,
                        );
                    }
                }
            }
            if (is_array($element)) {
                $this->_createPriceList($element, $regions, $type, $pricelist);
            };
        }
    }
    
    private function _createMaterialList($elements, &$materiallist) {
        
        $materialgroups = array(
            18, 429, 754, 966, 1034, 1040
        );
        foreach($elements as $element) {
            if ((is_array($element)) && (isset($element['typeID'])) && (isset($element['groupID']))) {
                if (in_array($element['groupID'], $materialgroups)) {
                    if ((!isset($elements['EveRamActivity']['activityID'])) || ($elements['EveRamActivity']['activityID']==1)) {
                        $materiallist[$element['typeID']] = array(
                            'typeID' => $element['typeID'],
                            'typeName' => $element['typeName']
                        );
                    }
                }
            }
            if (is_array($element)) {
                if ((!isset($elements['EveRamActivity']['activityID'])) || ($elements['EveRamActivity']['activityID']==1)) {
                    $this->_createMaterialList($element, $materiallist);
                }
            };
        }
    }
    
    private function _removeCachedPrices(&$pricelist) {
        
        foreach ($pricelist as $key => $item) {
            $params = array(
                'regionlimit' => array($item['region']), 
                'typeid' => array($item['typeID'])
            );
            if ($this->AleApi->isCached($params)) {
                unset($pricelist[$key]);
            }
        }
    }
}
?>
