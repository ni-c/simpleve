<div class="inner box">
    
    <?php 
        $regionlist = array(
            array(
                'region'    => $this->Tools->getMapLinks(0),
                'id'  => 'all',
            ),
            array(
                'region'    => $this->Tools->getMapLinks(10000002),
                'id'        => '10000002',
            ),
            array(
                'region'    => $this->Tools->getMapLinks(10000043),
                'id'        => '10000043',
            ),
            array(
                'region'    => $this->Tools->getMapLinks(10000030),
                'id'        => '10000030',
            ),
            array(
                'region'    => $this->Tools->getMapLinks(10000032),
                'id'        => '10000032',
            ),
        );
    ?>


    <?php $rnd = $tools->randomStr(); ?>
    <?php $sw = $tools->getSwitchArray((isset($options['marketdetails_tab'])) ? $options['marketdetails_tab'] : 0); ?>
    <h4><?php echo $html->image($sw['img'], array('alt' => '', 'class' => 'left switch', 'rel' => $rnd, 'callbacks' => "saveOption('marketdetails_tab', '1')"))?> Market Details</h4>
    <div class="clr"></div>            
    <table class="subbox material <?php echo $sw['class']; ?>" id="<?php echo $rnd; ?>">
        <thead>
            <tr>
                <th>Region</th>
                <th class="nr">Lowest Sell</th>
                <th class="nr">Highest Buy</th>
                <th class="nr">Median</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($regionlist as $region) { ?>
                <tr class="rowhover">
                    <td>
                        <?php echo $region['region']; ?>
                    </td>
                    <td class="nr">
                        <?php echo number_format($this->requestAction('prices/single/'.$typeID.'/'.$region['id'].'/sell'),2,'.',','); ?>
                    </td>
                    <td class="nr">
                        <?php echo number_format($this->requestAction('prices/single/'.$typeID.'/'.$region['id'].'/buy'),2,'.',','); ?>
                    </td>
                    <td class="nr">
                        <?php echo number_format($this->requestAction('prices/single/'.$typeID.'/'.$region['id'].'/median'),2,'.',','); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
