<?php 
    $html->addCrumb('Industry', '/industry');
    $html->addCrumb('Manufacturing Calculator', '/industry/manufacturingcalculator');
    $html->addCrumb($EveInvTypes['EveInvType']['typeName'], '/industry/manufacturingcalculator/' . $EveInvTypes['EveInvType']['typeID']); 
    $this->Html->script('manufacturingcalculator', array('inline' => false));
    echo $this->element('apinotice', array('siteName' => 'Manufacturing Calculator', 'fullRequired' => false));
?>

<?php echo $this->element('locationpicker', array('regionurl' => 'industry/manufacturingcalculator/'.$EveInvTypes['EveInvType']['typeID'].'/{regionID}', 'ShowCustomValues' => true)); ?>

<div class="box">
    <input type="hidden" id="production_efficiency" value="<?php echo $characterXml->getSkillLevel($active_character, 3388); ?>" />
    <input type="hidden" id="industry" value="<?php echo $characterXml->getSkillLevel($active_character, 3380); ?>" />
    <input type="hidden" id="science" value="<?php echo $characterXml->getSkillLevel($active_character, 3402); ?>" />
    <h3>Itemdata</h3>
    <div class="subbox">
               
        <div class="item">
            <?php 
                echo $this->element('industry_item', array('item' => $EveInvTypes, 'root' => true));
            ?>
        </div>
            
    </div>    
</div>
<div class="clr"></div>