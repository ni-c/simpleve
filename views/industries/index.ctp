<?php $html->addCrumb('Industry', '/industry'); ?>

<div class="box">
    <h3>
        <?php echo $this->Html->link('Manufacturing Calculator', '/industry/manufacturingcalculator'); ?>
    </h3>
    <div class="subbox">
        <?php echo $this->Html->link($this->Html->image('theme/manufacturing.png', array('alt' => '', 'class' => 'left')), '/industry/manufacturingcalculator', array('escape'=>false)); ?>
        <div class="info">
            The Manufacturing calculator is able to calculate Research and Manufacturing costs of each item in EVE Online, depending on your skill levels and the region where to manufacture.
        </div>
        <div class="clr"></div>
    </div>
</div>

<div class="box">
    <h3>
        <?php echo $this->Html->link('Refining Calculator', '/industry/refiningcalculator'); ?>
    </h3>
    <div class="subbox">
        <?php echo $this->Html->link($this->Html->image('theme/refining.png', array('alt' => '', 'class' => 'left')), '/industry/refiningcalculator', array('escape'=>false)); ?>
        <div class="info">
            Calculates mineral rates for each ore, depending on your skill level.
        </div>
        <div class="clr"></div>
    </div>
</div>
