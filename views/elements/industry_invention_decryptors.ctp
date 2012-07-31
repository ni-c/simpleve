<tr>
    <td colspan="3">
        &nbsp;
    </td>
    <td class="nr">
        Chance
    </td>
    <td class="nr">
        Runs
    </td>
    <td class="nr">
        ME
    </td>
    <td class="nr">
        PE
    </td>
    <td class="nr">
        &nbsp;
    </td>
</tr>
<?php $rRnd = $tools->randomStr(); ?>
<?php $iRnd = $tools->randomStr(); ?>
<tr id="<?php echo $rRnd; ?>_tr" class="switchrow switchbg">
    <td class="icon">
        <?php echo $html->image('theme/minus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rRnd))?>
    </td>
    <td>
        &nbsp;
    </td>
    <td>
        <strong>Cost per manufacturing run:</strong>
    </td>
    <td class="nr">
        <span class="calc invchance" id="<?php echo $iRnd; ?>_complete" rel="<?php echo $Invention['base_chance']; ?>" parent="<?php echo $completeresearchcost_hash; ?>"><?php echo $Invention['base_chance']*100; ?>%</span>
        <input type="hidden" id="<?php echo $iRnd; ?>_basechance" value="<?php echo $Invention['base_chance']; ?>"></input>
        <input type="hidden" id="<?php echo $iRnd; ?>_encryptionskilllevel" value="<?php echo $Invention['encryption_skill_level']; ?>"></input>
        <input type="hidden" id="<?php echo $iRnd; ?>_datacore1skilllevel" value="<?php echo $Invention['datacore_1_skill_level']; ?>"></input>
        <input type="hidden" id="<?php echo $iRnd; ?>_datacore2skilllevel" value="<?php echo $Invention['datacore_2_skill_level']; ?>"></input>
    </td>
    <td class="nr">
        <span class="calc" id="<?php echo $iRnd; ?>_baseruns" rel="<?php echo $Invention['base_runs']; ?>" pid="<?php echo $baseruns; ?>"><?php echo $Invention['base_runs']; ?></span>
    </td>
    <td class="nr">
        <span class="calc" id="<?php echo $iRnd; ?>_baseme" rel="<?php echo $Invention['base_me']; ?>" pid="<?php echo $pid; ?>_invme"><?php echo $Invention['base_me']; ?></span>
    </td>
    <td class="nr">
        <span class="calc" id="<?php echo $iRnd; ?>_basepe" rel="<?php echo $Invention['base_pe']; ?>" pid="<?php echo $pid; ?>_invpe"><?php echo $Invention['base_pe']; ?></span>
    </td>
    <td class="nr">
        <span class="calc complete" id="<?php echo $iRnd; ?>_priceperrun" pid="<?php echo $pid; ?>_invprice">0.00</span>
    </td>
</tr>
<tr id="<?php echo $rRnd; ?>">
    <td colspan="8" class="switchable">
        <div class="innertable box">
            <div class="subbox">
                <table class="decryptors" id="<?php echo $iRnd; ?>_decryptors">
                    <thead>
                        <tr>
                            <th colspan="2">
                                &nbsp;
                            </th>
                            <th>
                                Decryptor
                            </th>
                            <th class="nr">
                                Chance Modifier
                            </th>
                            <th class="nr">
                                Run Modifier
                            </th>
                            <th class="nr">
                                ME Modifier
                            </th>
                            <th class="nr">
                                PE Modifier
                            </th>
                            <th class="nr">
                                Price
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cRnd = $tools->randomStr(); ?>
                        <tr>
                            <td class="icon">
                                <span class="radiobutton selected" callbacks="calculateInvention()" rel="<?php echo $cRnd; ?>"></span>
                            </td>
                            <td class="icon">
                                &nbsp;
                            </td>
                            <td>
                                <a href="#">None</a>
                            </td>
                            <td class="class nr" rel="<?php echo $iRnd; ?>_probabilitymodifier">
                                1.0
                            </td>
                            <td class="nr" rel="<?php echo $iRnd; ?>_decryptorruns">
                                0
                            </td>
                            <td class="nr" rel="<?php echo $iRnd; ?>_decryptorme">
                                0
                            </td>
                            <td class="nr" rel="<?php echo $iRnd; ?>_decryptorpe">
                                0
                            </td>
                            <td class="nr">
                                0.00
                            </td>
                        </tr>
                        <?php foreach($Decryptors as $Decryptor) { ?>
                            <tr>
                                <td class="icon">
                                    <span class="radiobutton" callbacks="calculateInvention()" rel="<?php echo $cRnd; ?>"></span>
                                </td>
                                <td class="icon">
                                    <?php 
                                        echo $eveIcon->getIcon(
                                            16, 
                                            $Decryptor['EveGraphic'], 
                                            $Decryptor['EveInvType']['typeID'], 
                                            $Decryptor['EveInvGroup']['EveInvCategory']['categoryName'], 
                                            1
                                        ); 
                                    ?>
                                </td>
                                <td>
                                    <?php $rRnd = $tools->randomStr(); ?>
                                    <?php echo $tools->getItemLinks($Decryptor['EveInvType']['typeID'], false, $rRnd); ?>
                                </td>
                                <td class="nr" rel="<?php echo $iRnd; ?>_probabilitymodifier">
                                    <?php echo $Decryptor['probabilityMultiplier']; ?>
                                </td>
                                <td class="nr" rel="<?php echo $iRnd; ?>_decryptorruns">
                                    <?php
                                        if ($Decryptor['maxRunModifier']>0) {
                                            echo '+';
                                        } 
                                        echo $Decryptor['maxRunModifier']; 
                                    ?>
                                </td>
                                <td class="nr" rel="<?php echo $iRnd; ?>_decryptorme">
                                    <?php 
                                        if ($Decryptor['mineralEfficiencyModifier']>0) {
                                            echo '+';
                                        } 
                                        echo $Decryptor['mineralEfficiencyModifier']; 
                                    ?>
                                </td>
                                <td class="nr" rel="<?php echo $iRnd; ?>_decryptorpe">
                                    <?php
                                        if ($Decryptor['productionEfficiencyModifier']>0) {
                                            echo '+';
                                        } 
                                        echo $Decryptor['productionEfficiencyModifier']; 
                                    ?>
                                </td>
                                <td class="nr">
                                    <?php
                                        $price = $this->requestAction('prices/single/'.$Decryptor['EveInvType']['typeID'].'/'.$priceregion);
                                     ?>
                                    <input type="text" class="inputbox numeric decryptorprice customvalue" size="16" custom="price:<?php echo $Decryptor['EveInvType']['typeID']; ?>" value="<?php echo $price; ?>"></input>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php /* Meta Types */ ?>
                <?php if (count($MetaTypes)>0) { ?>
                    <table class="metatypes" id="<?php echo $iRnd; ?>_metatypes">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    &nbsp;
                                </th>
                                <th>
                                    Meta Type
                                </th>
                                <th class="nr">
                                    Chance Modifier
                                </th>
                                <th class="nr">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $cRnd = $tools->randomStr(); ?>
                            <tr>
                                <td class="icon">
                                    <span class="radiobutton selected" callbacks="calculateInvention()" rel="<?php echo $cRnd; ?>" id="<?php echo $iRnd; ?>_meta_0"></span>
                                </td>
                                <td class="icon">
                                    &nbsp;
                                </td>
                                <td>
                                    <a href="#">None</a>
                                </td>
                                <td class="nr">
                                    <?php echo number_format(1, 2, '.', ''); ?>
                                </td>
                                <td class="nr">
                                    0.00
                                </td>
                            </tr>
                            <?php $c = 1; ?>
                            <?php for ($i=1; $i < 5; $i++) {
                                foreach ($MetaTypes as $M) {
                                    if (($M['EveDgmTypeAttribute'][0]['valueFloat'] == $i) || ($M['EveDgmTypeAttribute'][0]['valueInt'] == $i)) {
                                        $MetaType = $M;
                                        break;
                                    } 
                                }
                            ?>
                                <tr>
                                    <td class="icon">
                                        <span class="radiobutton" callbacks="calculateInvention()" rel="<?php echo $cRnd; ?>" id="<?php echo $iRnd; ?>_meta_<?php echo $c; ?>"></span>
                                    </td>
                                    <td class="icon">
                                        <?php
                                            echo $eveIcon->getIcon(
                                                16, 
                                                $MetaType['EveInvType']['EveGraphic'], 
                                                $MetaType['EveInvType']['typeID'], 
                                                $MetaType['EveInvType']['EveInvGroup']['EveInvCategory']['categoryName'], 
                                                1
                                            ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php $rRnd = $tools->randomStr(); ?>
                                        <?php echo $tools->getItemLinks($MetaType['EveInvType']['typeID'], false, $rRnd); ?>
                                    </td>
                                    <td class="nr">
                                        <?php $chance = (1 + (($Invention['datacore_1_skill_level'] + $Invention['datacore_2_skill_level']) * (0.1 / (5 - $c)))); ?>
                                        <?php echo number_format($chance, 2, '.', ''); ?>
                                    </td>
                                    <td class="nr">
                                        <?php
                                            $price = $this->requestAction('prices/single/'.$MetaType['EveInvType']['typeID'].'/'.$priceregion);
                                         ?>
                                        <input type="text" class="inputbox numeric metatypeprice customvalue" size="16" custom="price:<?php echo $MetaType['EveInvType']['typeID']; ?>" value="<?php echo $price; ?>"></input>
                                    </td>
                                </tr>
                                <?php $c++; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </td>
</tr>
