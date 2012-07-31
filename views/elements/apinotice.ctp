
<?php if (!isset($active_character)) { ?>
    <div class="box">
        <h3 class="apiinfo">
            No active API found
        </h3>
        <div class="subbox">
            <?php echo $this->Html->link('Please enter your full API information to use the full functionality of the ' . $siteName . '!', '/settings'); ?>
        </div>
    </div>
<?php } else if ((isset($fullRequired)) && ($fullRequired == true)) { ?>
    <?php if ($limitedApi) { ?>
        <div class="box">
            <h3 class="apiinfo">
                Limited API key
            </h3>
            <div class="subbox">
                <?php echo $this->Html->link('Please enter your full API information to use all the functionalitiy of the ' . $siteName . '!', '/settings'); ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>
