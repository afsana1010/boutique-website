<?php if (!isset($error) && !isset($success)): ?>
    <legend><h3><?php echo $form_title; ?></h3></legend>
    <?php echo form_open('register/forgot_password', array('id' => 'forgot_password_input_form','class'=>'form-horizontal')) ?>

        <div class="control-group">
            <label class="control-label" for="email_address">Email Address</label>
            <div class="controls">
                <?php echo form_input(array('name' => 'email_address', 'id' => 'email_address', 'maxlength' => '80')) ?>
                <?php echo "<br /><small>Type the email address that you use to login. </small>" ?>
                <?php echo form_error('activation_code', '<span class="help-inline">', '</span>') ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="button"></label>
            <button type="submit" class="btn">Submit</button>
        </div>

        <div class="row">
            <div class="span10" style="background-color:#333; height:2px;"></div>
        </div>
    <?php echo form_close() ?>
<?php endif ?>