<?php $html->addCrumb('Character', '/character'); ?>

<div class="box">
    <h3>
        <?php echo $this->Html->link('Wallet', '/character/wallet'); ?>
    </h3>
    <div class="subbox">
        <?php echo $this->Html->link($this->Html->image('theme/wallet.png', array('alt' => '', 'class' => 'left')), '/character/wallet', array('escape'=>false)); ?>
        <div class="info">
            The wallet information of your current character.
        </div>
        <div class="clr"></div>
    </div>
</div>
