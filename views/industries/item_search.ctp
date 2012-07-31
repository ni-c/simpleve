<?php $html->addCrumb('Industry', '/industry'); ?>
<?php $html->addCrumb('Manufacturing Calculator', '/industry/manufacturingcalculator'); ?>

<?php
    $this->Html->script('manufacturingcalculator', array('inline' => false));
    $this->Html->script('locationpicker', array('inline' => false));
?>

<div class="box">
    <h3>Search Item</h3>
    <div class="subbox">
    
        <div class="inner box">
            <?php $rnd = $tools->randomStr(); ?>
            <h4><?php echo $html->image('theme/minus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Search</h4>
            <div class="clr"></div>            
            <div class="subbox" id="<?php echo $rnd; ?>">
                <?php echo $form->create('Industry', array('action' => 'item_search')); ?>
                <fieldset class="itemsearch">
                    <table class="subbox">
                        <tr>
                            <td>
                                <?php echo $form->label('typeName', 'Item name:'); ?>
                            </td>
                            <td>
                                <?php echo $form->input('EveInvType.typeName', array('label' => false, 'class' => 'inputbox', 'tabindex' => '1', 'error' => false, 'size' => '30')); ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <?php
                    echo $form->end('Search');
                ?>
            </div>
        </div>

        <?php if (isset($EveInvTypes)) { ?>
            <div class="inner box">
                <?php $rnd = $tools->randomStr(); ?>
                <h4><?php echo $html->image('theme/minus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?> Results</h4>
                <div class="clr"></div>            
                <div class="subbox material" id="<?php echo $rnd; ?>">

                    <?php if (count($EveInvTypes)>0) { ?>
                        <table class="subbox material">
                            <?php foreach($EveInvTypes as $EveInvType) {?>
                                <tr>
                                    <td class="icon">
                                        <?php 
                                            echo $eveIcon->getIcon(
                                                16, 
                                                $EveInvType['EveGraphic'], 
                                                $EveInvType['EveInvType']['typeID'], 
                                                $EveInvType['EveInvGroup']['EveInvCategory']['categoryName'], 
                                                ((isset($EveInvType['Product_EveInvBlueprintType'])) ? $EveInvType['Product_EveInvBlueprintType']['techLevel'] : 1)
                                            ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $this->Tools->getItemLinks($EveInvType['EveInvType']['typeID']);
                                        ?>    
                                    </td>
                                    <td>
                                        <?php
                                            echo $EveInvType['EveInvGroup']['EveInvCategory']['categoryName'];
                                        ?>    
                                    </td>
                                    <td>
                                        <?php
                                            echo $EveInvType['EveInvGroup']['groupName'];
                                        ?>    
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                        No item found.   
                    <?php } ?>
                    
                </div>
            </div>
        <?php } ?>
    </div>    
</div>
<div class="clr"></div>            
