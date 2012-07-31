<?php $rRnd = $tools->randomStr(); ?>
<?php $cRnd = $tools->randomStr(); ?>
<tr id="<?php echo $rRnd; ?>_tr" class="switchrow rowhover">
    <td class="icon">
        <?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rRnd))?>
    </td>
    <td class="icon">
        <?php 
            echo $eveIcon->getIcon(
                16, 
                $EveInvTypeMaterial['EveInvType']['EveGraphic'], 
                $EveInvTypeMaterial['EveInvType']['typeID'], 
                $EveInvTypeMaterial['EveInvType']['EveInvGroup']['EveInvCategory']['categoryName'], 
                ((isset($EveInvTypeMaterial['Product_EveInvBlueprintType'])) ? $EveInvTypeMaterial['Product_EveInvBlueprintType']['techLevel'] : 1)
            ); 
        ?>
    </td>
    <td>
        <?php echo $tools->getItemLinks($EveInvTypeMaterial['EveInvType']['typeID'], false, $rRnd); ?>
    </td>
    <td class="nr">
        <span rel="<?php echo $EveInvTypeMaterial['quantity'] ?>" class="quantity"><?php echo number_format($EveInvTypeMaterial['quantity'],0,'.',','); ?></span>
    </td>
    <td class="nr">
        <?php 
        if (!isset($EveInvTypeMaterial['waste_quantity'])) {
            $waste_quantity = $EveInvTypeMaterial['quantity'];
            $default_quantity =  $EveInvTypeMaterial['quantity'];
            $your_quantity =  $EveInvTypeMaterial['quantity'];
        } else {
            $waste_quantity = $EveInvTypeMaterial['waste_quantity'];  
            $default_quantity = $EveInvTypeMaterial['default_quantity'];  
            $your_quantity = $EveInvTypeMaterial['your_quantity'];  
        }
        ?>
        <span rel="<?php echo $waste_quantity ?>"><?php echo number_format($waste_quantity,0,'.',','); ?></span>
    </td>
    <td class="nr">
        <span <?php if (!isset($nocalc)) { ?>class="calc mequantity"<?php } ?> rel="<?php echo $default_quantity; ?>"><?php echo number_format($default_quantity,0,'.',','); ?></span>
    </td>
    <td class="nr<?php if (($characterXml->getSkillLevel($active_character, 3388)==5) && ((!isset($options['yourme_column'])) || ($options['yourme_column']==0))) { echo " hidden"; } ?>">
        <span class="<?php if (!isset($nocalc)) { ?>calc yourquantity <?php } ?><?php if (isset($MaterialList[$EveInvTypeMaterial['EveInvType']['typeID']])) { echo 'shoppinglistitem'; } ?>" rel="<?php echo $your_quantity; ?>" typeid="<?php echo $EveInvTypeMaterial['EveInvType']['typeID']; ?>" id="<?php echo $cRnd; ?>_quantity"<?php if ((isset($hash)) && ($hash!='0') && (isset($MaterialList[$EveInvTypeMaterial['EveInvType']['typeID']]))) { echo ' parent="' . $hash . '_quantity"'; }?>><?php echo number_format($your_quantity,0,'.',','); ?></span>
    </td>
    <td class="nr">
        <?php
            $id = (!isset($EveInvTypeMaterial['materialTypeID'])) ? $EveInvTypeMaterial['EveInvType']['typeID'] : $EveInvTypeMaterial['materialTypeID'];
            $price = $this->requestAction('prices/single/'.$id.'/'.$priceregion);
        ?>
        <input type="text" class="pricebox numeric customvalue" size="10" id="<?php echo $cRnd; ?>" custom="price:<?php echo $id; ?>" value="<?php echo $price; ?>"></input>
    </td>
    <td class="nr">
        <span class="calc price" id="<?php echo $cRnd; ?>_price" rel="0">0.00</span>
    </td>
</tr>
<tr class="hidden" id="<?php echo $rRnd; ?>">
    <?php 
        if (($characterXml->getSkillLevel($active_character, 3388)==5) && ((!isset($options['yourme_column'])) || ($options['yourme_column']==0))) {
            $colspan = "8"; 
        } else {
            $colspan = "9";
        } 
    ?>
    <td colspan="<?php echo $colspan; ?>" class="switchable">
        <div class="innertable box">
            <div class="subbox">
                <?php 
                    echo $this->element('industry_item', array('item' => $EveInvTypeMaterial['EveInvType'], 'hash' => $cRnd));
                ?>
            </div>
        </div>
    </td>
</tr>
