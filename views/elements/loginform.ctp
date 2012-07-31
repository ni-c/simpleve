<h3>Login</h3>
<div class="login">
    <?php
        echo $session->flash('auth');
        echo $form->create('User', array('action' => 'login'));
    ?>
    <fieldset class="loginform">
        <?php 
            echo $form->input('User.username', array('label'=>'Username', 'class' => 'inputbox', 'error' => false, 'value' => '', 'size' => '18'));
            echo $form->input('User.password', array('label'=>'Password', 'class' => 'inputbox', 'error' => false, 'size' => '18')); 
        ?>
        <div class="input rememberlogin">
            <?php
                echo $form->checkbox('User.remember_me', array('class' => 'rememberme'));
                echo $form->label('User.remember_me', 'Remember Me');
            ?>
        </div>
    </fieldset>
    <?php
        echo $form->end('Login');
    ?>
</div>
<ul class="menu">
    <li>
        <a href="<?php echo $html->url('/lostpw', true); ?>">
            <span class='hover'>Lost password?</span>
        </a>
    </li>
    <li>
        <a href="<?php echo $html->url('/signup', true); ?>">
            <span class='hover'>Sign up</span>
        </a>
    </li>
</ul>
