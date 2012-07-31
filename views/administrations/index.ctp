<div class="box">
    <h3>
        Subscription account
    </h3>
    <div class="subbox">
        <?php echo $form->create('Administration', array('action' => 'save_api')); ?>
        <fieldset>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $form->input('Administration.subscription_api_user_id', array('type' => 'text', 'label' => 'User ID', 'class' => 'inputbox', 'error' => false, 'value' => $data['Administration']['subscription_api_user_id'] , 'size' => '10')); ?>
                        </td>
                        <td>
                            <?php echo $form->input('Administration.subscription_api_key', array('label' => 'API Key', 'class' => 'inputbox', 'error' => false, 'value' => $data['Administration']['subscription_api_key'], 'size' => '80')); ?>
                        </td>
                        <td>
                            <?php
                                echo $this->Html->link(
                                    'Save',
                                    '/administrations/save_api/',
                                    array(
                                        'class' => 'smallbutton',
                                        'onclick' => 'document.forms["AdministrationSaveApiForm"].submit();'));
                            ?>
                        </td>
                    </tr>
                    <?php if ((isset($SubscriptionCharacters)) && (!empty($SubscriptionCharacters))) { ?>
                        <tr>
                            <td>
                                Character:
                            </td>
                            <td colspan="2">
                                <select name="data[Administration][subscription_character_id]">
                                <?php foreach($SubscriptionCharacters[0]->getSimpleXMLElement()->result->rowset->row as $character) { ?>
                                    <?php $attributes = $character->attributes(); ?>
                                    <option value="<?php echo $attributes['characterID']; ?>" <?php if ($attributes['characterID']==$data['Administration']['subscription_character_id']) { echo 'selected="selected"'; } ?>><?php echo $attributes['name']; ?></option>                            
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </fieldset>
    </div>
</div>

<div class="box">
    <h3>
        Cronjob URLs
    </h3>
    <div class="subbox">
        <ul>
            <li>
                <?php echo $this->Html->link('Update Mineral Index', '/mineralIndexTypes/update', array('target' => '_blank')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Update Alliances', '/eveapi/update/eve/AllianceList', array('target' => '_blank')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Update Sovereignty', '/eveapi/update/map/Sovereignty', array('target' => '_blank')); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Update Subscriptions', '/administrations/updateSubscriptions', array('target' => '_blank')); ?>
            </li>
        </ul>
    </div>
</div>

<div class="box">
    <h3>
        Development
    </h3>
    <div class="subbox">
        <ul>
            <li>
            <?php if ((isset($generalOptions['sign_up_enabled'])) && ($generalOptions['sign_up_enabled']==1)) { ?>
                User sign up is enabled (<?php echo $this->Html->link('disable', '/administrations/setGeneralOption/sign_up_enabled/0'); ?>)
            <?php } else { ?>
                User sign up is disabled (<?php echo $this->Html->link('enable', '/administrations/setGeneralOption/sign_up_enabled/1'); ?>)
            <?php } ?>
            </li>
            <li>
                <?php echo $this->Html->link('Rebuild ACL', '/users/build_acl', array('target' => '_blank')); ?>
            </li>
        </ul>
    </div>
</div>

<div class="box">
    <h3>
        Subscription Journal
    </h3>
    <div class="subbox">
        <table>
            <thead>
                <tr>
                    <th>
                        Ref ID
                    </th>
                    <th>
                        Character ID
                    </th>
                    <th>
                        Character Name
                    </th>
                    <th>
                        Reason
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Date
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($SubscriptionJournal as $journalentry) { ?>
                    <tr>
                        <td>
                            <?php echo $journalentry['SubscriptionJournal']['ref_id']; ?>
                        </td>
                        <td>
                            <?php echo $journalentry['SubscriptionJournal']['character_id']; ?>
                        </td>
                        <td>
                            <?php echo $this->Tools->getCharacterLinks($journalentry['SubscriptionJournal']['character_id']); ?>
                        </td>
                        <td>
                            <?php echo $journalentry['SubscriptionJournal']['reason']; ?>&nbsp;
                        </td>
                        <td>
                            <?php echo number_format($journalentry['SubscriptionJournal']['amount'],2,'.',',');; ?>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $journalentry['SubscriptionJournal']['timestamp']); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>