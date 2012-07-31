<?php $this->Html->script('locationpicker', array('inline' => false)); ?>
<div class="box locationpicker">
    <h3>Location</h3>
    <div class="subbox">
        <input type="hidden" id="region_url" value="<?php echo $regionurl; ?>">
        <select id="region_select">
            <?php if (isset($ShowCustomValues)) { ?>
                <option value="custom">Custom Values</option>
            <?php } ?>
            <?php foreach($Regions as $Region) { ?>
                <option value="<?php echo $Region['EveMapRegion']['regionID']; ?>"<?php if ($Region['EveMapRegion']['regionID']==$priceregion) echo ' selected="selected"'; ?>><?php echo $Region['EveMapRegion']['regionName']; ?></option>
            <?php } ?>
        </select>
        <a class="smallbutton" href="" id="location_apply">Load Prices</a>
    </div>
</div>
 