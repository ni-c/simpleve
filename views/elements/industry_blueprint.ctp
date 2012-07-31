<div class="inner box">
    <?php $rnd = $tools->randomStr(); ?>
    <?php $sw = $tools->getSwitchArray((isset($options['blueprint_tab'])) ? $options['blueprint_tab'] : 0); ?>
    <h4><?php echo $html->image($sw['img'], array('alt' => '', 'class' => 'left switch', 'rel' => $rnd, 'callbacks' => "saveOption('blueprint_tab', '1')"))?> Blueprint</h4>
    <div class="clr"></div>
    <div class="subbox <?php echo $sw['class']; ?>" id="<?php echo $rnd; ?>">           
        <?php echo $eveIcon->getBlueprintIcon(
            $blueprint['blueprintTypeID'], 
            $blueprint['Blueprint_EveInvType']['typeName'], 
            $blueprint['techLevel']); ?>
        <div class="iteminfo">
            <strong><?php echo $blueprint['Blueprint_EveInvType']['typeName']; ?></strong>
            <?php echo $eveIgb->showInfo($blueprint['blueprintTypeID']); ?>
        </div>
        <div class="clr"></div>
        <div class="inner box">
            <?php $rnd = $tools->randomStr(); ?>
            <h5><?php echo $html->image('theme/minus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Base Data</h5>
            <table class="subbox split" id="<?php echo $rnd; ?>">
                <tbody>
                    <tr class="rowhover">
                        <td>
                            Max Runs per Blueprint copy:
                        </td>
                        <td>
                            <?php echo $blueprint['maxProductionLimit']; ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Wastage Factor:
                        </td>
                        <td>
                            <?php echo $blueprint['wasteFactor']; ?> &#37;
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Manufacturing Time:
                        </td>
                        <td>
                            <?php echo $timespan->format($blueprint['productionTime']); ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Manufacturing Time (You):
                        </td>
                        <td class="calc">
                            <?php 
                                $pt_modifier = 1 - 0.01 * ((int)$characterXml->getSkillLevel($active_character, 3380) * 4);
                                echo $timespan->format(round($blueprint['productionTime'] * $pt_modifier)); 
                            ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Research Productivity Level Time:
                        </td>
                        <td>
                            <?php echo $timespan->format($blueprint['researchProductivityTime']); ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Research Productivity Level Time (You):
                        </td>
                        <td class="calc">
                            <?php 
                                $rpet_modifier = 1 - 0.01 * ((int)$characterXml->getSkillLevel($active_character, 3403) * 5);
                                echo $timespan->format(round($blueprint['researchProductivityTime'] * $rpet_modifier)); 
                            ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Research Material Efficiency Time:
                        </td>
                        <td>
                            <?php echo $timespan->format($blueprint['researchMaterialTime']); ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Research Material Efficiency Time (You):
                        </td>
                        <td class="calc">
                            <?php 
                                $rmet_modifier = 1 - 0.01 * ((int)$characterXml->getSkillLevel($active_character, 3409) * 5);
                                echo $timespan->format(round($blueprint['researchMaterialTime'] * $rmet_modifier)); 
                            ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Research Copy Time:
                        </td>
                        <td>
                            <?php echo $timespan->format($blueprint['researchCopyTime']); ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Research Copy Time (You):
                        </td>
                        <td class="calc">
                            <?php 
                                $ct_modifier = 1 - 0.01 * ((int)$characterXml->getSkillLevel($active_character, 3402) * 5);
                                echo $timespan->format(round($blueprint['researchCopyTime'] * $ct_modifier)); 
                            ?>
                        </td>
                    </tr>
                    <tr class="rowhover">
                        <td>
                            Invention Time:
                        </td>
                        <td>
                            <?php echo $timespan->format($blueprint['researchTechTime']); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="inner box">
            <?php $rnd = $tools->randomStr(); ?>
            <h5><?php echo $html->image('theme/minus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Additional Data</h5>
            <table class="subbox split" id="<?php echo $rnd; ?>">
                <tbody>
                    <tr class="rowhover">
                        <td>
                            Perfect ME:
                        </td>
                        <td>
                            <span class="calc"><?php echo (isset($blueprint['perfect_me'])) ? $blueprint['perfect_me'] : '0'; ?></span>
                        </td>
                    </tr>
                    <?php if ($blueprint['techLevel']==2) { ?>
                        <tr class="rowhover">
                            <td>
                                Manufacturing Time PE -4 (You): 
                            </td>
                            <td>
                                <span class="calc"><?php echo $timespan->format(round($blueprint['pe_m4_productionTime'] * $pt_modifier)); ?></span>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php
                        $pes = array(1,2,3,4,5,10,25,50,100);
                        foreach ($pes as $pe) {
                    ?>
                        <tr class="rowhover">
                            <td>
                                Manufacturing Time PE <?php echo $pe ?> (You): 
                            </td>
                            <td>
                                <span class="calc"><?php echo $timespan->format(round($blueprint['pe' . $pe .'_productionTime'] * $pt_modifier)); ?></span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clr"></div>            
</div>            
