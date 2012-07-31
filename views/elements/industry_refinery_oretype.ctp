<?php 
    $rRnd = $this->Tools->randomStr(); 
    $skill = $this->Tools->getSkill($oreSkill, $active_character, $rRnd . '_skill', 'calcEfficiencies()');
?>
<tr id="<?php echo $rRnd; ?>_tr" class="switchrow rowhover">
    <td class="icon">
        <?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rRnd))?>
    </td>
    <td class="icon">
        <?php echo $skill['icon']; ?>
    </td>
    <td>
        <?php echo $skill['name']; ?>
    </td>
    <td>
        <?php echo $skill['image']; ?>
    </td>
    <td>
        <span class="calc refineryefficiency" id="<?php echo $rRnd; ?>_efficiency">100%</span>
    </td>
    <td style="width:400px;">
        &nbsp;
    </td>
</tr>
<tr class="hidden" id="<?php echo $rRnd; ?>">
    <td colspan="6" class="switchable">
        <div class="innertable box">
            <table class="subbox refiningcalculatortable">
                <thead>
                    <tr>
                        <th>
                            Ore
                        </th>
                        <th>
                            Price
                        </th>
                        <th class="hidden">
                            &nbsp;
                        </th>
                        <th>
                            <?php 
                                echo $this->Tools->getItemLinks('Tritanium', true); 
                            ?>
                        </th>
                        <th>
                            <?php 
                                echo $this->Tools->getItemLinks('Pyerite', true); 
                            ?>
                        </th>
                        <th>
                            <?php 
                                echo $this->Tools->getItemLinks('Mexallon', true); 
                            ?>
                        </th>
                        <th>
                            <?php 
                                echo $this->Tools->getItemLinks('Isogen', true); 
                            ?>
                        </th>
                        <th>
                            <?php 
                                echo $this->Tools->getItemLinks('Nocxium', true); 
                            ?>
                        </th>
                        <th>
                            <?php 
                                echo $this->Tools->getItemLinks('Zydrine', true); 
                            ?>
                        </th>
                        <th>
                            Gain
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            &nbsp;
                        </th>
                        <td class="hidden">
                            &nbsp;
                        </td>
                        <th class="nr">
                            <?php
                                $rnd = $tools->randomStr();
                                $EveInvType = $this->requestAction('/database/invtype/Tritanium');
                                $id = $EveInvType['EveInvType']['typeID'];
                                $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion . '/sell');
                            ?>
                            <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $rRnd . '_0_price'; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                        </th>
                        <th class="nr">
                            <?php
                                $rnd = $tools->randomStr();
                                $EveInvType = $this->requestAction('/database/invtype/Pyerite');
                                $id = $EveInvType['EveInvType']['typeID'];
                                $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion . '/sell');
                            ?>
                            <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $rRnd . '_1_price'; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                        </th>
                        <th class="nr">
                            <?php
                                $rnd = $tools->randomStr();
                                $EveInvType = $this->requestAction('/database/invtype/Mexallon');
                                $id = $EveInvType['EveInvType']['typeID'];
                                $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion . '/sell');
                            ?>
                            <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $rRnd . '_2_price'; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                        </th>
                        <th class="nr">
                            <?php
                                $rnd = $tools->randomStr();
                                $EveInvType = $this->requestAction('/database/invtype/Isogen');
                                $id = $EveInvType['EveInvType']['typeID'];
                                $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion . '/sell');
                            ?>
                            <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $rRnd . '_3_price'; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                        </th>
                        <th class="nr">
                            <?php
                                $rnd = $tools->randomStr();
                                $EveInvType = $this->requestAction('/database/invtype/Nocxium');
                                $id = $EveInvType['EveInvType']['typeID'];
                                $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion . '/sell');
                            ?>
                            <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $rRnd . '_4_price'; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                        </th>
                        <th class="nr">
                            <?php
                                $rnd = $tools->randomStr();
                                $EveInvType = $this->requestAction('/database/invtype/Zydrine');
                                $id = $EveInvType['EveInvType']['typeID'];
                                $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion . '/sell');
                            ?>
                            <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $rRnd . '_5_price'; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($Ores as $ore) { ?>
                        <tr>
                            <td>
                                <?php 
                                    echo $this->Tools->getItemLinks($ore['name'], true);
                                ?>
                            </td>
                            <td>
                                <?php
                                    $rnd = $tools->randomStr();
                                    $EveInvType = $this->requestAction('/database/invtype/' . $ore['name']);
                                    $id = $EveInvType['EveInvType']['typeID'];
                                    $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion);
                                ?>
                                <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $rRnd . '_' . $id . '_price'; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
                            </td>
                            <td class="nr hidden">
                                <span id="<?php echo $rRnd . '_' . $id . '_refinesize'; ?>"><?php echo $refineSize; ?></span>
                            </td>
                            <?php for ($i = 0; $i<6; $i++) { ?>
                                <td class="nr">
                                    <?php
                                        if ((isset($ore['result'][$i])) && ($ore['result'][$i]['value'] > 0)) {
                                            ?>
                                            <span id="<?php echo $rRnd . '_' . $id . '_' . $i . '_value' ?>"><?php echo $ore['result'][$i]['value']; ?></span>
                                            <?php 
                                        } else {
                                            ?>
                                            <span id="<?php echo $rRnd . '_' . $id . '_' . $i . '_value' ?>">0</span>
                                            <?php 
                                        } 
                                    ?>
                                </td>
                            <?php } ?>
                            <td class="nr">
                                <span class="calc refiningvalue" id="<?php echo $rRnd . '_' . $id . '_sum'; ?>">+0.00 %</span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </td>
</tr>
