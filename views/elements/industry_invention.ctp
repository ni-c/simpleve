<div class="inner box">

    <?php $rnd = $tools->randomStr(); ?>
    <?php $sw = $tools->getSwitchArray((isset($options['invention_tab'])) ? $options['invention_tab'] : 0); ?>
    <h4><?php echo $html->image($sw['img'], array('alt' => '', 'class' => 'left switch', 'rel' => $rnd, 'callbacks' => "saveOption('invention_tab', '1')"))?> Invention</h4>
    <div class="clr"></div>            
    <table class="subbox invention <?php echo $sw['class']; ?>" id="<?php echo $rnd; ?>">
        <thead>
            <tr>
                <th class="icon" colspan="2">
                    &nbsp;
                </th>
                <th colspan="3">
                    Material
                </th>
                <th class="nr">
                    Count
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
            <?php foreach($item['Blueprint_EveInvType']['EveRamTypeRequirement'] as $eveRamTypeRequirement) { ?>
                <?php if ($eveRamTypeRequirement['EveRamActivity']['activityID']==8) { ?>
                    <?php $rRnd = $tools->randomStr(); ?>
                    <?php $cRnd = $tools->randomStr(); ?>
                    <tr class="switchrow rowhover" id="<?php echo $rRnd; ?>_tr">
                        <td class="icon">
                            <?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rRnd))?>
                        </td>
                        <td class="icon">
                            <?php 
                                echo $eveIcon->getIcon(
                                    16, 
                                    $eveRamTypeRequirement['EveInvType']['EveGraphic'], 
                                    $eveRamTypeRequirement['EveInvType']['typeID'], 
                                    $eveRamTypeRequirement['EveInvType']['EveInvGroup']['EveInvCategory']['categoryName'], 
                                    1
                                ); 
                            ?>
                        </td>
                        <td colspan="3">
                            <?php echo $tools->getItemLinks($eveRamTypeRequirement['EveInvType']['typeID'], false, $cRnd); ?>
                        </td>
                        <td class="nr">
                            <span rel="<?php echo $eveRamTypeRequirement['quantity'] ?>" class="quantity" id="<?php echo $cRnd; ?>_quantity"><?php echo number_format($eveRamTypeRequirement['quantity'],0,'.',','); ?></span>
                        </td>
                        <td class="nr">
                            <?php if ($eveRamTypeRequirement['EveInvType']['groupID']!=716) { ?>
                                <?php
                                    $id = (!isset($eveRamTypeRequirement['materialTypeID'])) ? $eveRamTypeRequirement['EveInvType']['typeID'] : $eveRamTypeRequirement['materialTypeID'];
                                    $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion);
                                ?>
                                <input type="text" class="inputbox numeric inventionprice customvalue" size="10" id="<?php echo $cRnd; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                            <?php } else { ?>
                                &nbsp;
                            <?php } ?>
                        </td>
                        <td class="nr">
                            <?php if ($eveRamTypeRequirement['EveInvType']['groupID']!=716) { ?>
                                <span class="calc price decryptorprice" id="<?php echo $cRnd; ?>_price" rel="0">0.00</span>
                            <?php } else { ?>
                                &nbsp;
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="hidden" id="<?php echo $rRnd; ?>">
                        <td colspan="9" class="switchable">
                            <div class="innertable box">
                                <div class="subbox">
                                    <?php 
                                        echo $this->element('industry_item', array('item' => $eveRamTypeRequirement['EveInvType']));
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td colspan="7">
                    &nbsp;
                </td>
                <td class="nr">
                    <span class="calc complete" id="<?php echo $rnd; ?>_researchmaterialcost">0.00</span>
                </td>
            </tr>
<?php // Blueprint cost ?>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td>
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
                    <span class="checkbox checked" callbacks="bpCopyCalc('<?php echo $rnd; ?>');calculateAllInventions();calculateCompleteCost()" id="<?php echo $rnd; ?>_blueprintcostcheckbox"></span>
                </td>
                <td>
                    <?php echo $eveIcon->getBlueprintIcon(
                        $item['Blueprint_EveInvType']['typeID'],
                        $item['Blueprint_EveInvType']['typeName'],
                        1,
                        true); ?>
                </td>
                <td>
                    <?php $rRnd = $tools->randomStr(); ?>
                    <?php echo $tools->getItemLinks($item['Blueprint_EveInvType']['typeID'], false, $rRnd); ?>
                    <input type="hidden" value="<?php echo $item['researchCopyTime']; ?>" id="<?php echo $rnd; ?>_researchCopyTime"></input>
                    <input type="hidden" value="<?php echo $item['maxProductionLimit']; ?>" id="<?php echo $rnd; ?>_maxProductionLimit"></input>
                    <input type="hidden" value="1" id="<?php echo $rnd; ?>_baseruns"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="copyinstallcost:0" value="<?php echo (isset($CustomValues['copyinstallcost'][0])) ? $CustomValues['copyinstallcost'][0] : '1000.00'; ?>" id="<?php echo $rnd; ?>_bp_installcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="copyhourcost:0" value="<?php echo (isset($CustomValues['copyhourcost'][0])) ? $CustomValues['copyhourcost'][0] : '1208.00'; ?>" id="<?php echo $rnd; ?>_bp_hourcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="timemultiplier:0" value="<?php echo (isset($CustomValues['copytimemultiplier'][0])) ? $CustomValues['copytimemultiplier'][0] : '1.0'; ?>" id="<?php echo $rnd; ?>_bp_timemultiplier"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpcopycalc customvalue" size="6" custom="standing:0" value="<?php echo (isset($CustomValues['standing'][0])) ? $CustomValues['standing'][0] : '0.0'; ?>" id="<?php echo $rnd; ?>_bp_standing"></input>
                </td>
                <td class="nr">
                    <span class="calc complete" id="<?php echo $rnd; ?>_blueprintcost" rel="0.0">0.00</span>
                </td>
            </tr>
<?php // Invention cost ?>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td>
                    <strong>Invention cost:</strong>
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
            <tr class="blueprintresearchcost" rel="<?php echo $rnd; ?>">
                <td>
                    <span class="checkbox checked" callbacks="bpResearchCalc('<?php echo $rnd; ?>');calculateAllInventions();calculateCompleteCost()" id="<?php echo $rnd; ?>_blueprintresearchcheckbox"></span>
                </td>
                <td>
                    <?php echo $eveIcon->getBlueprintIcon(
                        $item['Blueprint_EveInvType']['typeID'],
                        $item['Blueprint_EveInvType']['typeName'],
                        1,
                        true); ?>
                </td>
                <td>
                    <?php $rRnd = $tools->randomStr(); ?>
                    <?php echo $tools->getItemLinks($item['Blueprint_EveInvType']['typeID'], false, $rRnd); ?>
                    <input type="hidden" value="<?php echo $item['researchTechTime']; ?>" id="<?php echo $rnd; ?>_researchTechTime"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpresearchcalc customvalue" size="6" custom="researchinstallcost:0" value="<?php echo (isset($CustomValues['researchinstallcost'][0])) ? $CustomValues['researchinstallcost'][0] : '1000.00'; ?>" id="<?php echo $rnd; ?>_bp_installcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpresearchcalc customvalue" size="6" custom="researchhourcost:0" value="<?php echo (isset($CustomValues['researchhourcost'][0])) ? $CustomValues['researchhourcost'][0] : '1208.00'; ?>" id="<?php echo $rnd; ?>_bp_hourcost"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpresearchcalc customvalue" size="6" custom="copytimemultiplier:0" value="<?php echo (isset($CustomValues['researchtimemultiplier'][0])) ? $CustomValues['researchtimemultiplier'][0] : '1.0'; ?>" id="<?php echo $rnd; ?>_bp_timemultiplier"></input>
                </td>
                <td class="nr">
                    <input type="text" class="inputbox numeric bpresearchcalc customvalue" size="6" custom="standing:0" value="<?php echo (isset($CustomValues['standing'][0])) ? $CustomValues['standing'][0] : '0.0'; ?>" id="<?php echo $rnd; ?>_bp_standing"></input>
                </td>
                <td class="nr">
                    <span class="calc complete" id="<?php echo $rnd; ?>_researchcost">0.00</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
                <td colspan="5">
                    <strong>Cost per invention run:</strong>
                </td>
                <td class="nr">
                    <span class="calc complete completeresearchcost" id="<?php echo $rnd; ?>_completeresearchcost" rel="0">0.00</span>
                </td>
            </tr>
            <?php 
                echo $this->element('industry_invention_decryptors', array('completeresearchcost_hash' => $rnd, 'pid' => $pid, 'baseruns' => $rnd, 'item' => $item));
            ?>
        </tbody>
    </table>
</div>