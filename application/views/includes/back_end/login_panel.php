<?php echo form_open('', array('id' => 'login_panel')) ?>

<div class="notification information png_bg">
    <div id="status">
        <?php echo $default_status_message; ?>
    </div>
</div>

<p>
    <label>Email Address</label>
    <?php echo form_input(array('name' => 'user_email', 'class' => 'text-input', 'id' => 'user_email', 'maxlength' => '80')) ?>
</p>
<div class="clear"></div>
<p>
    <label>Password</label>
    <?php echo form_password(array('name' => 'user_pass', 'class' => 'text-input', 'id' => 'user_pass', 'maxlength' => '15')) ?>
</p>
<div class="clear"></div>
<!--
<p id="remember-password">
        <input id="chk_remember" type="checkbox" />Remember me
</p>
-->
<div class="clear"></div>
<div>
    <?php echo form_hidden('base_url', base_url()) ?>
    <?php echo form_button(array('class' => 'button', 'id' => 'submit_btn', 'content' => 'Sign In', 'style' => 'width:80px;')) ?>
    <!--<a href="javascript: jQuery.facebox({div:'#forgot_panel'});" id="forgot_link">Forgot Password?</a>-->
</div>

<div class="clear"></div>
<!--
<div id="forgot_panel" style="display:none;">
        <fieldset>
                <legend><strong>Forgot Your Access Code?</strong></legend>
                        <p>
                                <input class="text-input" type="text" id="email_to_recover" name="email_to_recover" size="30" maxlength="80" value="Type Email Address" />
                        </p>
                        <div class="clear"></div>
                        <p>
                                <input class="text-input" type="text" id="dob_to_recover" name="dob_to_recover" size="30" maxlength="10" value="Date of Birth(YYYY-MM-DD)" />
                        </p>
                        <div class="clear"></div>
                        <div id="recover_btn_row">
                                <input type="button" id="recover_btn" class="button" value="Continue" />
                        </div>
                        <div class="clear"></div>
                        <div id="recover_status"></div>
        </fieldset>
</div>
-->

<?php echo form_close(); ?>