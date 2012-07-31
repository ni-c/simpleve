<?php $html->addCrumb('Sign Up', '/users/add'); ?>
<div class="box">
    <?php if ($sign_up_enabled==1) { ?>
        <h3>Create new account</h3>
        <div class="subbox">
            For security reasons, Please do not use your <a href="http://www.eveonline.com" target="_blank">EVE Online</a> username and/or password! 
        </div>
        <?php echo $form->create('User', array('action' => 'add', 'class' => 'subbox')); ?>
        <fieldset class="adduser">
            <table>
                <tr>
                    <td>
                        <?php echo $form->label('username', 'Username:'); ?>
                    </td>
                    <td>
                        <?php echo $form->input('User.username', array('label' => false, 'class' => 'inputbox', 'tabindex' => '1', 'error' => false, 'size' => '30')); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo $form->error('User.username'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->label('email', 'Email:'); ?>
                    </td>
                    <td>
                        <?php echo $form->input('User.email', array('label' => false, 'class' => 'inputbox', 'tabindex' => '2', 'error' => false, 'size' => '30')); ?>
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
                        <?php echo $form->label('passwd', 'Password:'); ?>
                    </td>
                    <td>
                        <?php echo $form->input('User.passwd', array('label' => false, 'class' => 'inputbox', 'tabindex' => '3', 'error' => false, 'value' => '', 'size' => '30')); ?>
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
                        <?php echo $form->label('passwd2', 'Repeat password:'); ?>
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
        <?php echo $form->end('Create account'); ?>
    <?php } else { ?>
        <h3>Sign up deactivated</h3>
        <div class="subbox">
            Signing up is currently disabled for new users, please try again later.
        </div>
    <?php } ?>
</div>