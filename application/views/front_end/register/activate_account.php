<?php if (!isset($error) && !isset($success)): ?>
    <legend><h3><?php echo $form_title; ?></h3></legend>
    <?php echo form_open('register/activate_account/' . $user_email, array('id' => 'activation_input_form','class'=>'form-horizontal')) ?>

        <div class="control-group">
            <label class="control-label" for="activation_code">Activation Code</label>
            <div class="controls">
                <?php echo form_input(array('name' => 'activation_code', 'id' => 'activation_code', 'maxlength' => '4')) ?>
                <?php echo "<br /><small>Type the 4-digit code that you got by SMS. </small>" ?>
                <?php echo form_error('activation_code', '<span class="help-inline">', '</span>') ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="button"></label>
            <button type="submit" class="btn btn-large btn-primary">Activate</button>
        </div>

        <div class="row">
            <div class="span10" style="background-color:#333; height:2px;"></div>
        </div>
    <?php echo form_close() ?>
<?php endif ?>