<?php 
    if (isset($item['EveInvType'])) {
        $EveInvType = $item['EveInvType'];
    } else {
        $EveInvType = $item;
    }
echo $eveIcon->getIcon(
        64, 
        $item['EveGraphic'], 
        $EveInvType['typeID'], 
        $item['EveInvGroup']['EveInvCategory']['categoryName'], 
        ((count($item['Product_EveInvBlueprintType'])>0) ? $item['Product_EveInvBlueprintType']['techLevel'] : 1)); ?>
<div class="iteminfo">
    <?php $rRnd = $tools->randomStr(); ?>
    <strong id="<?php echo $rRnd; ?>_item">
        <?php echo $tools->getItemLinks($EveInvType['typeID'], false, $rRnd); ?>
    </strong>
    <div class="itemdata">
        <?php echo nl2br($EveInvType['description']); ?>
    </div>
</div>
<div class="clr"></div>

<?php
     $idRnd = $tools->randomStr();

    // Blueprint 
    if (isset($item['Product_EveInvBlueprintType']['blueprintTypeID'])) {
        echo $this->element('industry_blueprint', 
            array('blueprint' => $item['Product_EveInvBlueprintType'])
        );
    }

    if (isset($root)) {
        // Invention
        if ((isset($item['EveInvMetaType']['typeID'])) && ($item['EveInvMetaType']['typeID']!='')) {
            echo $this->element('industry_invention',
                array(
                    'item' => $item['EveInvMetaType']['ParentEveInvType']['Product_EveInvBlueprintType'],
                    'pid' => $idRnd
                )
            );
        } else {
            if ((isset($item['Product_EveInvBlueprintType'])) && ($item['Product_EveInvBlueprintType']['blueprintTypeID']!='')) {
                echo $this->element('industry_invention',
                    array(
                        'item' => $item['Product_EveInvBlueprintType'],
                        'pid' => $idRnd
                    )
                );
            }
        }
    }
    
    // Manufacturing
    if (!isset($hash)) {
        $hash = '0';
    }
    if ((isset($item['Product_EveInvBlueprintType']['Blueprint_EveInvType']))) {
        echo $this->element('industry_material', 
            array(
                'typeID' => $EveInvType['typeID'],
                'materials' => $item['EveInvTypeMaterial'],
                'blueprint' => $item['Product_EveInvBlueprintType'],
                'ramTypeRequirements' => $item['EveRamTypeRequirement'],
                'bpRamTypeRequirements' => ((isset($item['Product_EveInvBlueprintType']['Blueprint_EveInvType']['EveRamTypeRequirement'])) ? $item['Product_EveInvBlueprintType']['Blueprint_EveInvType']['EveRamTypeRequirement'] : array()),
                'techLevel' => ((isset($item['Product_EveInvBlueprintType']['techLevel'])) ? $item['Product_EveInvBlueprintType']['techLevel'] : 1),
                'eveinvtype' => $EveInvType,
                'hash' => $hash,
                'pid' => $idRnd,
                'root' => $root,
                'MaterialList' => $MaterialList
            )
        );
    }

    if ((isset($options['marketdetails'])) && ($options['marketdetails']==1)) {
        // Market Details
        echo $this->element('industry_marketdetails', 
            array('typeID' => $EveInvType['typeID'])
        );
    }
?>