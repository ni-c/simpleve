<h3><?php echo $User['username']; ?></h3>
<div>
    <?php if ($User['group_id']==1) { ?>
        <div class="subbox">
            <strong class="apiinfo">Your SimplEve subscription is expired!</strong><br /><br />
            <strong class="apiinfo">Please go to your </strong><a href="<?php echo $html->url('/settings', true); ?>">account settings</a><strong class="apiinfo"> to reactivate your account.</strong>
        </div>
    <?php } ?>

    <?php if (isset($APIException)) { ?>
        <div class="subbox apiinfo">
            <strong class="apiinfo">EVE API Exception:</strong><br /><br />
            <?php echo $APIException; ?>
        </div>
    <?php } ?>

    <?php if (isset($active_character)) { ?>
        <div class="characterbox">
            <img src="http://image.eveonline.com/Character/<?php echo $active_character['characterID']; ?>_128.jpg" />
            <?php echo $active_character['api']->name; ?><br />
            <?php echo number_format((float)$active_character['api']->balance->__toString(),2,'.',','); ?> ISK<br />
        </div>

        <div class="box characterselect">
            <?php $rnd = $tools->randomStr(); ?>
            <?php $sw = $tools->getSwitchArray((isset($options['character_list'])) ? $options['character_list'] : 0); ?>
            <h4><?php echo $html->image($sw['img'], array('alt' => '', 'class' => 'left switch', 'rel' => $rnd, 'callbacks' => "saveOption('character_list', '1')"))?> Characters</h4>
            <div class="clr"></div>            
            <div class="subbox characterlist<?php echo $sw['class'];?>" id="<?php echo $rnd; ?>">
                <table>
                    <tbody>
                        <?php 
                            foreach($apis as $api) {
                                if ($api['Api']['errorcode']<200) {
                                    foreach($characters[$api['Api']['id']] as $character) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $this->Html->link(
                                                    $this->Html->image(
                                                        'http://image.eveonline.com/Character/' . $character['characterID'] . '_32.jpg',
                                                        array('class' => 'charportrait')),
                                                    '/character/' . $character['characterID'],
                                                    array('escape' => false)); ?>
                                            </td>
                                            <td>
                                                <?php echo $this->Html->link(
                                                    $character['api']->name,
                                                    '/character/' . $character['characterID']); ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    
        <div class="clr"></div>

    <?php } else { ?>
    
    <div class="characterbox">
        <?php echo $this->Html->link('No active API found!', '/users/edit'); ?>
    </div>
    
    <?php } ?>

    <ul class="menu">
        <li>
            <a href="<?php echo $html->url('/settings', true); ?>">
                <span class='hover'>Account Settings</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $html->url('/options', true); ?>">
                <span class='hover'>Options</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $html->url('/logout', true); ?>">
                <span class='hover'>Logout</span>
            </a>
        </li>
    </ul>
</div>
