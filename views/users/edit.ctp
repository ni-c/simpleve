<?php $html->addCrumb('Account Settings', '/users/edit'); ?>

<div class="box">
    <h3>Account Information</h3>
    <div class="subbox">
        <table>
            <tr>
                <td>
                    Username:
                </td>
                <td>
                    <strong><?php echo $User['username']; ?></strong>
                </td>
            </tr>
            <tr>
                <td>
                    Account status:
                </td>
                <td>
                    <?php switch ($User['group_id']) {
                        case 1:
                            echo 'Subscription expired';
                            break;
                        case 2:
                            echo 'Trial';
                            break;
                        case 3:
                            echo 'Subscriber';
                            break;
                        case 4:
                            echo 'Moderator';
                            break;
                        case 5:
                            echo 'Administrator';
                            break;
                    } ?>
                </td>
            </tr>
            <tr>
                <td>
                    Expires:
                </td>
                <td>
                    <?php if ($User['expires'] == 0) {
                        echo 'Never';
                    } else {
                        echo date('Y-m-d H:i',$User['expires']);
                    }?>
                </td>
            </tr>
            <tr>
                <td>
                    Balance:
                </td>
                <td>
                    <?php echo number_format($User['balance'],2,'.',',') . ' ISK'; ?>
                </td>
            </tr>
        </table>
        <?php if (isset($generalOptions['subscription_character_id'])) { ?>
            <div class="box">
                <?php $rnd = $tools->randomStr(); ?>
                <h4><?php echo $html->image('theme/plus.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd, 'callbacks' => "saveOption('blueprint_tab', '1')"))?> Subscription</h4>
                <div class="subbox hidden" id="<?php echo $rnd; ?>">
                    <div class="subbox">
                        To reactivate your account or extend your subscription, send your ISK (using a character that is registered in your SimplEve-Account) to<br />
                        "<?php echo $this->Tools->getCharacterLinks($generalOptions['subscription_character_id']) ?>".
                        <br /><br />
                        Registered Characters:
                        <?php 
                            $chars = '';
                            foreach($apis as $api) {
                                if ($api['Api']['errorcode']<200) {
                                    foreach($characters[$api['Api']['id']] as $character) {
                                        $chars = $chars . ', ' . $this->Tools->getCharacterLinks($character['characterID']);
                                    }
                                }
                            } 
                            if ($chars=='') {
                                echo 'none - Please update your API settings.';
                            } else {
                                echo substr($chars, 2);
                            }
                        ?>
                        <br /><br />
                        On the next API update, your subscription will automatically start, this can take up some time. You may have to logout and login again.<br /><br />
                        Subscriptions bought will not be refundable.<br /><br />
                        If you pay more than the price of a subcription, anything above the limit will be added to your SimplEve wallet. At the next time, you just have to pay the difference between your wallet and the subscription you want.<br /><br />
                    </div>
                    <div class="subbox">
                        <table>
                            <thead>
                                <th colspan="2">
                                    Pricing:
                                </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        30 day subscription
                                    </td>
                                    <td>
                                        20.000.000 ISK
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        90 day subscription
                                    </td>
                                    <td>
                                        50.000.000 ISK
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        365 day subscription
                                    </td>
                                    <td>
                                        180.000.000 ISK
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>           
            </div>
        <?php } ?>
    </div>
</div>
<div class="box">
    <h3>Change Email / Password</h3>
    <?php echo $form->create('User', array('action' => 'edit', 'class' => 'subbox')); ?>
    <fieldset class="edituser">
        <table>
            <tr>
                <td>
                    <?php echo $form->label('email', 'Email:'); ?>
                </td>
                <td>
                    <?php echo $form->input('User.email', array('label' => false, 'class' => 'inputbox', 'tabindex' => '1', 'error' => false, 'size' => '30', 'value' => $User['email'])); ?>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                    <?php echo $form->error('User.email'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->label('passwd', 'New Password:'); ?>
                </td>
                <td>
                    <?php echo $form->input('User.passwd', array('label' => false, 'class' => 'inputbox', 'tabindex' => '2', 'error' => false, 'value' => '', 'size' => '30')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                    <?php echo $form->error('User.passwd'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->label('passwd2', 'Repeat new password:'); ?>
                </td>
                <td>
                    <?php echo $form->input('User.passwd2', array('label' => false, 'class' => 'inputbox', 'type' => 'password', 'tabindex' => '3', 'error' => false, 'value' => '', 'size' => '30')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                    <?php echo $form->error('User.passwd2'); ?>
                </td>
            </tr>
        </table>
    </fieldset>    
    <?php echo $form->end('Change Password'); ?>
</div>

<div class="box">
    <h3>Eve Online API</h3>
    <div class="subbox">
        Visit <a href="http://www.eveonline.com/api">http://www.eveonline.com/api</a> to get your API information. 
        <?php echo $form->create('User', array('action' => 'add_api')); ?>
        <table class="subbox full">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>User ID</th>
                    <th>API Key</th>
                    <th colspan="2">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allApis as $api) { ?>
                <?php $rnd = $tools->randomStr(); ?>
                <tr id="<?php echo $rnd; ?>_tr"<?php if ($api['Api']['errorcode']>=200) { echo ' class="switchbg"'; } ?>>
                    <td class="icon">
                        <?php if ($api['Api']['errorcode']>=200) { $img = 'minus'; } else { $img = 'plus'; } ?>
                        <?php echo $html->image('theme/'. $img . '.gif', array('alt' => '', 'class' => 'left switch', 'rel' => $rnd))?>
                    </td>
                    <td<?php if ($api['Api']['errorcode']>=200) { echo ' class="apiinfo"'; } ?>>
                            <?php echo $api['Api']['api_user_id']; ?>
                    </td>
                    <td<?php if ($api['Api']['errorcode']>=200) { echo ' class="apiinfo"'; } ?>>
                        <?php echo $api['Api']['api_key']; ?>
                    </td>
                    <td>
                        <?php 
                            echo $this->Html->link(
                                'Remove',
                                '/users/remove_api/' . $api['Api']['api_user_id'],
                                array('class' => 'smallbutton'));
                        ?>
                    </td>
                </tr>
                
                <tr id="<?php echo $rnd; ?>"<?php if ($api['Api']['errorcode']<200) { echo ' class="hidden"'; } ?>>
                    <td colspan="4" class="switchable">
                        <div class="innertable box">
                            <div class="subbox">
                                <?php if ($api['Api']['errorcode']>=200) { ?>
                                    API Error. (Code: <a href="http://www.eveonline.com/api/doc/errors.asp" target="_blank"><?php echo $api['Api']['errorcode']; ?></a>)
                                <?php } else { ?>
                                    <?php if ($api['Api']['is_active']==0) { ?>
                                        API is deactivated.
                                    <?php } else { ?>
                                        <?php foreach($characters[$api['Api']['id']] as $character) { ?>
                                            <div class="left charbox">
                                                <img src="http://image.eveonline.com/Character/<?php echo $character['api']->characterID; ?>_128.jpg" /><br /><br />
                                                <?php echo $character['api']->name; ?><br />
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clr"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                </tr>
                
                <?php } ?>
                <tr>
                    <td class="icon">
                        &nbsp;
                    </td>
                    <td>
                        <?php echo $form->input('User.api_user_id', array('type' => 'text', 'label' => false, 'class' => 'inputbox', 'error' => false, 'value' => '', 'size' => '10')); ?>
                    </td>
                    <td>
                        <?php echo $form->input('User.api_key', array('label' => false, 'class' => 'inputbox', 'error' => false, 'value' => '', 'size' => '80')); ?>
                    </td>
                    <td>
                        <?php
                            echo $this->Html->link(
                                'Add',
                                '#',
                                array(
                                    'class' => 'smallbutton formsubmit',
                                    'rel' => 'UserAddApiForm')
                                );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="subbox">
                            <ul>
                                <li>Please enter your <strong>full</strong> API key to take the full advantage of SimplEve.</li>
                                <li><strong>User ID</strong>s can only be used one time, if a User ID is already registered with another SimplEve account, you have to remove it from this account before adding.</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="box">
    <h3>Simpleve API key</h3>
    <div class="subbox">
        <table>
            <tbody>
                <tr>
                    <td>
                        User ID:
                    </td>
                    <td>
                        <?php echo $user['id'] + 1000000; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        API Key:
                    </td>
                    <td>
                        <?php echo $user['hash']; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="subbox">
            You can generate a new API key here. Please note that all programs and web sites that are using your old API key will no longer be able to access your data unless you provide them with the new API key.<br /><br />
            <?php
                echo $this->Html->link(
                    'New API key',
                    '/users/newapikey',
                    array(
                        'class' => 'smallbutton')
                    );
            ?>
        </div>
    </div>
</div>