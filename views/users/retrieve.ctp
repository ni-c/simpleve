<?php $html->addCrumb('Lost password', '/users/retrieve'); ?>
<div class="box">
    <h3>Request new password</h3>
    <?php echo $form->create('User', array('action' => 'retrieve', 'class' => 'subbox')); ?>
    <fieldset class="retrievepw">
        <table>
            <tr>
                <td>
                    <?php echo $form->label('email', 'Your Email:'); ?>
                </td>
                <td>
                    <?php echo $form->input('User.email', array('label' => false, 'class' => 'inputbox', 'tabindex' => '1', 'error' => false, 'size' => '30')); ?>
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
        </table>
    </fieldset>    
    <?php echo $form->end('Request new password'); ?>
</div>