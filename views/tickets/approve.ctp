<h1>Change Password</h1>
<div class="addusercontainer">
    <?php echo $form->create('Ticket', array('action' => 'approve')); ?>
    <fieldset class="adduser">
        <div class="left">
            <div class="adduserinputcontainer">
                <?php echo $form->input('User.passwd', array('label'=>'New Password', 'class' => 'inputbox', 'tabindex' => '1', 'error' => false, 'value' => '', 'size' => '30')); ?>
                <?php echo $form->error('User.passwd'); ?>
            </div>
        </div>
        <div class="right">
            <div class="adduserinputcontainer">
                <?php echo $form->input('User.passwd2', array('label'=>'Repeat Password', 'class' => 'inputbox', 'type' => 'password', 'tabindex' => '2', 'error' => false, 'value' => '', 'size' => '30')); ?>
                <?php echo $form->error('User.passwd2'); ?>
            </div>
        </div>
        <div class="clr"></div>
        <?php echo $form->hidden('Ticket.hash', array('error' => false, 'value' => $hash)); ?>
    </fieldset>
    <?php echo $form->end('Change Password'); ?>
</div>