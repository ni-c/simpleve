<div class="inner box">

    <?php $rnd = $tools->randomStr(); ?>
    <?php $sw = $tools->getSwitchArray((isset($options['manufacturing_tab'])) ? $options['manufacturing_tab'] : 0); ?>
    <h4><?php echo $html->image($sw['img'], array('alt' => '', 'class' => 'left switch', 'rel' => $rnd, 'callbacks' => "saveOption('manufacturing_tab', '1')"))?> Manufacturing</h4>
    <div class="clr"></div>            
    <table class="subbox material <?php echo $sw['class']; ?>" id="<?php echo $rnd; ?>">
        <thead>
            <tr>
                <th class="icon" colspan="2">
                    &nbsp;
                </th>
                <th>
                    Material
                </th>
                <th class="me nr">
                    Base
                </th>
                <th class="me nr">
                    ME 0
                </th>
                <?php
                    if ($techLevel==2) {
                        $meLvl = -4;
                        $peLvl = -4;
                    } else {
                        $meLvl = 0;
                        $peLvl = 0;
                    }
                    if (isset($CustomValues['me'][$blueprint['blueprintTypeID']])) {
                        $meLvl = $CustomValues['me'][$blueprint['blueprintTypeID']];
                    }
                    if (isset($CustomValues['pe'][$blueprint['blueprintTypeID']])) {
                        $peLvl = $CustomValues['pe'][$blueprint['blueprintTypeID']];
                    }
                ?>
                <th class="me nr">
                    <input type="hidden" id="<?php echo $pid; ?>_me" rel="<?php echo $rnd; ?>_me"></input>
                    ME <input type="text" class="inputbox meinput customvalue" size="1" rel="<?php echo $rnd; ?>"  custom="me:<?php echo $blueprint['blueprintTypeID']; ?>" id="<?php echo $rnd; ?>_me" value="<?php echo $meLvl; ?>"></input>
                </th>
                <th class="me nr<?php if (($characterXml->getSkillLevel($active_character, 3388)==5) && ((!isset($options['yourme_column'])) || ($options['yourme_column']==0))) { echo " hidden"; } ?>">
                    You (ME <span class="calc" id="<?php echo $rnd . '_yme'; ?>"><?php echo $meLvl; ?></span>)
                </th>
                <th class="nr">
                    Price
                </th>
                <th class="nr">
                    Total Price
                </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($materials as $EveInvTypeMaterial) {
                    if (!isset($hash)) {
                        $hash = '0';
                    }
                    echo $this->element('industry_material_row', array('EveInvTypeMaterial' => $EveInvTypeMaterial, 'hash' => $hash));
                } 
                foreach($ramTypeRequirements as $EveRamTypeRequirement) {
                    if (($EveRamTypeRequirement['EveRamActivity']['activityID']==1) && ($EveRamTypeRequirement['EveInvType']['EveInvGroup']['categoryID']!=16)) {
                        echo $this->element('industry_material_row', array('EveInvTypeMaterial' => $EveRamTypeRequirement, 'nocalc' => 1));
                    }
                } 
                foreach($bpRamTypeRequirements as $EveRamTypeRequirement) {
                    if (($EveRamTypeRequirement['EveRamActivity']['activityID']==1) && ($EveRamTypeRequirement['EveInvType']['EveInvGroup']['categoryID']!=16)) {
                        echo $this->element('industry_material_row', array('EveInvTypeMaterial' => $EveRamTypeRequirement, 'nocalc' => 1));
                    }
                } 
            ?>
            <?php 
                if (($characterXml->getSkillLevel($active_character, 3388)==5) && ((!isset($options['yourme_column'])) || ($options['yourme_column']==0))) {
                    $csmod = -1; 
                } else {
                    $csmod = 0;
                } 
            ?>
            <tr>
                <td colspan="<?php echo 8+$csmod; ?>">
                    &nbsp;
                </td>
                <td class="nr">
                    <span class="calc complete" id="<?php echo $rnd; ?>_materialcost">0.00</span>
                </td>
            </tr>
<?php // Blueprint cost ?>
<?php if ($blueprint['techLevel']==1) { ?>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td colspan="<?php echo 2+$csmod; ?>">
                    <strong>Blueprint copy cost:</strong>
                </td>
                <td class="nr">
                    <strong>Install cost</strong>
                </td>
                <td class="nr">
                    <strong>Cost per hour</strong>
                </td>
                <td class="nr">
                    <strong>Time Multiplier</strong>
                </td>
                <td class="nr">
                    <strong>Standing</strong>
                </td>
                <td>
                   &nbsp; 
                </td>
            </tr>
            <tr class="blueprintcopycost" rel="<?php echo $rnd; ?>">
                <td>
                    <span class="checkbox checked" callbacks="bpCopyCalc('<?php echo $rnd; ?>');calculateCompleteCost()" id="<?php echo $rnd; ?>_blueprintcostcheckbox"></span>
                </td>
                <td>
                    <?php echo $eveIcon->getBlueprintIcon(
                        $blueprint['Blueprint_EveInvType']['typeID'],
                        $blueprint['Blueprint_EveInvType']['typeName'],
                        1,
                        true); ?>
                </td>
                <td colspan="<?php echo 2+$csmod; ?>">
                    <?php $rRnd = $tools->randomStr(); ?>
                    <?php echo $tools->getItemLinks($blueprint['Blueprint_EveInvType']['typeID'], false, $rRnd); ?>
                    <input type="hidden" value="<?php echo $blueprint['researchCopyTime']; ?>" id="<?php echo $rnd; ?>_researchCopyTime"></input>
                    <input type="hidden" value="<?php echo $blueprint['maxProductionLimit']; ?>" id="<?php echo $rnd; ?>_maxProductionLimit"></input>
                    <input type="hidden" value="1" id="<?php echo $rnd; ?>_baseruns"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="copyinstallcost:0" value="<?php echo (isset($CustomValues['copyinstallcost'][0])) ? $CustomValues['copyinstallcost'][0] : '1000.00'; ?>" id="<?php echo $rnd; ?>_bp_installcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="copyhourcost:0" value="<?php echo (isset($CustomValues['copyhourcost'][0])) ? $CustomValues['copyhourcost'][0] : '1208.00'; ?>" id="<?php echo $rnd; ?>_bp_hourcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="copytimemultiplier:0" value="<?php echo (isset($CustomValues['copytimemultiplier'][0])) ? $CustomValues['copytimemultiplier'][0] : '1.0'; ?>" id="<?php echo $rnd; ?>_bp_timemultiplier"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="standing:0" value="<?php echo (isset($CustomValues['standing'][0])) ? $CustomValues['standing'][0] : '0.0'; ?>" id="<?php echo $rnd; ?>_bp_standing"></input>
                </td>
                <td class="nr">
                    <span class="calc complete" id="<?php echo $rnd; ?>_blueprintcost" rel="0.0">0.00</span>
                </td>
            </tr>
<?php } else { ?>
             <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td colspan="<?php echo 7+$csmod; ?>">
                    <strong>Blueprint invention cost (per run):</strong>
                </td>
            </tr>
            <tr class="blueprintinvcost" rel="<?php echo $rnd; ?>">
                <td>
                    <span class="checkbox checked" id="<?php echo $rnd; ?>_blueprintcostcheckbox" callbacks="calculateInvention()"></span>
                    <input type="hidden" value="<?php echo $blueprint['researchCopyTime']; ?>" id="<?php echo $rnd; ?>_researchCopyTime"></input>
                    <input type="hidden" value="<?php echo $blueprint['maxProductionLimit']; ?>" id="<?php echo $rnd; ?>_maxProductionLimit"></input>
                </td>
                <td>
                    <?php echo $eveIcon->getBlueprintIcon(
                        $blueprint['Blueprint_EveInvType']['typeID'],
                        $blueprint['Blueprint_EveInvType']['typeName'],
                        1,
                        true); ?>
                </td>
                <td colspan="<?php echo 6+$csmod; ?>">
                    <?php $rRnd = $tools->randomStr(); ?>
                    <?php echo $tools->getItemLinks($blueprint['Blueprint_EveInvType']['typeID'], false, $rRnd); ?>
                </td>
                <td class="nr">
                    <input type="hidden" id="<?php echo $pid; ?>_price" rel="<?php echo $rnd; ?>_blueprintcost"></input>
                    <span class="calc complete" id="<?php echo $rnd; ?>_blueprintcost" rel="0.0">0.00</span>
                </td>
            </tr>
<?php } ?>
<?php // Manufacturing cost ?>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td colspan="<?php echo 2+$csmod; ?>">
                    <strong>Manufacturing cost:</strong>
                </td>
                <td class="nr">
                    <strong>Install cost</strong>
                </td>
                <td class="nr">
                    <strong>Cost per hour</strong>
                </td>
                <td class="nr">
                    <strong>Time Multiplier</strong>
                </td>
                <td class="nr">
                    <strong>Standing</strong>
                </td>
                <td>
                   &nbsp; 
                </td>
            </tr>
            <tr class="manufactoringcost" rel="<?php echo $rnd; ?>">
                <td>
                    <span class="checkbox checked" callbacks="peCalc('<?php echo $rnd; ?>');calculateCompleteCost()" id="<?php echo $rnd; ?>_manufacturingcostcheckbox"></span>
                </td>
                <td>
                    <?php echo $eveIcon->getBlueprintIcon(
                        $blueprint['Blueprint_EveInvType']['typeID'],
                        $blueprint['Blueprint_EveInvType']['typeName'],
                        1,
                        true); ?>
                </td>
                <td colspan="<?php echo 2+$csmod; ?>">
                    <?php $rRnd = $tools->randomStr(); ?>
                    <?php echo $tools->getItemLinks($blueprint['Blueprint_EveInvType']['typeID'], false, $rRnd); ?>
                    <input type="hidden" value="<?php echo $blueprint['productionTime']; ?>" id="<?php echo $rnd; ?>_productiontime"></input>
                    <input type="hidden" value="<?php echo $blueprint['productivityModifier']; ?>" id="<?php echo $rnd; ?>_productivitymodifier"></input>
                    &nbsp; <strong>PE</strong> 
                    <input type="hidden" id="<?php echo $pid; ?>_pe" rel="<?php echo $rnd; ?>_pe"></input>
                    <input type="text" class="inputbox numeric peinput manucalc customvalue" size="6" value="<?php echo $peLvl; ?>" id="<?php echo $rnd; ?>_pe" custom="pe:<?php echo $blueprint['blueprintTypeID']; ?>"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric manucalc customvalue" size="6" custom="manufacturinginstallcost:0" value="<?php echo (isset($CustomValues['manufacturinginstallcost'][0])) ? $CustomValues['manufacturinginstallcost'][0] : '1000.00'; ?>" id="<?php echo $rnd; ?>_installcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric manucalc customvalue" size="6" custom="manufacturinghourcost:0" value="<?php echo (isset($CustomValues['manufacturinghourcost'][0])) ? $CustomValues['manufacturinghourcost'][0] : '333.00'; ?>" id="<?php echo $rnd; ?>_hourcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric manucalc customvalue" size="6" custom="manufacturingtimemultiplier:0" value="<?php echo (isset($CustomValues['manufacturingtimemultiplier'][0])) ? $CustomValues['manufacturingtimemultiplier'][0] : '1.0'; ?>" id="<?php echo $rnd; ?>_timemultiplier"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric manucalc customvalue" size="6" custom="standing:0" value="<?php echo (isset($CustomValues['standing'][0])) ? $CustomValues['standing'][0] : '0.0'; ?>" id="<?php echo $rnd; ?>_standing"></input>
                </td>
                <td class="nr">
                    <span class="calc complete" id="<?php echo $rnd; ?>_manufacturingcost">0.00</span>
                </td>
            </tr>
            <tr>
                <td colspan="<?php echo 6+$csmod; ?>">
                    &nbsp;
                </td>
                <td class="nr">
                    <?php echo $eveinvtype['portionSize']; ?> x
                    <input type="hidden" id="<?php echo $rnd; ?>_portionsize" value="<?php echo $eveinvtype['portionSize']; ?>"></input>
                </td>
                <td class="nr">
                    <span class="calc complete completecost" id="<?php echo $rnd; ?>_completecost" rel="0"<?php if ($hash!='0') { echo 'parent="' . $hash . '"'; }?>>0.00</span>
                </td>
                <td class="nr">
                    <span class="calc complete" id="<?php echo $rnd; ?>_completecostperitem" rel="0"<?php if ($hash!='0') { echo 'parent="' . $hash . '"'; }?>>0.00</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td colspan="<?php echo 6+$csmod; ?>">
                    <strong>Market Price (Lowest Sell Order):</strong>
                </td>
                <td class="nr">
                    <span class="calc"><strong><?php echo number_format($this->requestAction('prices/single/'.$typeID.'/'.$priceregion.'/sell'),2,'.',','); ?></strong></span>
                </td>
            </tr>
            <tr>
                <td colspan="9">
                    <?php
                        if (isset($root)) {
                            echo $this->element('industry_manufacturing_shopping_list',
                                array(
                                    'MaterialList' => $MaterialList
                                )
                            );
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>