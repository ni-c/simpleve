<?php $html->addCrumb('Industry', '/industry'); ?>
<?php $html->addCrumb('Manufacturing Calculator', '/industry/manufacturingcalculator'); ?>

<?php
    $this->Html->script('priceupdater', array('inline' => false));
?>

<div class="box">
    <h3>Updating market data</h3>
    <div class="subbox">
        Updating market data from <a href="http://www.eve-central.com" target="_blank">Eve Central</a>, please wait..
        <?php
            $i = 0; 
            foreach ($pricelist as $price) { 
            
        ?>
            <input type="hidden" class="priceinfo" id="price_<?php echo $i; ?>" name="price_<?php echo $i; ?>" value="<?php echo $price['typeID']; ?>,<?php echo $price['region']; ?>,<?php echo $price['type']; ?>" />
        <?php
                $i++; 
            } 
        ?>
        <input type="hidden" id="max_progress" name="max_progress" value="<?php echo $i; ?>" />
        <input type="hidden" id="update_prices" name="update_prices" value="true" />
        
        <div id="progressbarborder">
            <div id="progressbar" style="width:0px;">
            </div>
        </div>
        
        <?php echo $form->create('Industry', array('url' => '/industry/manufacturingcalculator/' . $id . '/' . $region, 'id' => 'PriceUpdateCompleted')); ?>
        <fieldset class="itemsearch">
            <?php echo $form->input('Industry.cached', array('type' => 'hidden', 'value' => 1, 'error' => false)); ?>
        </fieldset>
        <?php
            echo $form->end();
        ?>
    </div>
</div>
<div class="clr"></div>