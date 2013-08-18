<h3><?php echo $form_title; ?></h3>
<?php echo form_open('register/login', array('id' => 'register_input_form','class'=>'form-horizontal')) ?>
<?php if (isset($previously_browse_page)): ?>
<?php echo form_hidden('previously_browse_page',$previously_browse_page); ?>
<?php endif; ?>
    <div class="control-group">
		<label class="control-label" for="email_address">Email</label>
		<div class="controls">
			<?php echo form_input(array('name' => 'email_address', 'id' => 'email_address', 'placeholder'=>'Email', 'maxlength' => '100', 'value' => isset($email_address) ? $email_address : set_value('email_address'))) ?>
			<?php echo form_error('full_name', '<span class="help-inline">Please provide valid email address', '</span>') ?>
		</div>
    </div>
	
    <div class="control-group">
		<label class="control-label" for="user_password">Password</label>
		<div class="controls">
			<?php echo form_input(array('name' => 'user_password', 'type'=>'password', 'id' => 'user_password', 'placeholder'=>'Password', 'maxlength' => '60', 'value' => isset($user_password) ? $user_password : set_value('user_password'))) ?>
			<?php echo form_error('user_password', '<span class="help-inline">Please provide valid password', '</span>') ?>
		</div>
    </div>
	
    <div class="control-group">
		<label class="control-label" for="button"></label>
		<?php echo form_submit(array('name' => 'submit_login_input', 'id' => 'submit_login_input', 'class'=>'btn','type' => 'submit'), 'Sign in') ?>
	</div>
	
	<div class="row">
		<div class="span10" style="background-color:#333; height:2px;"></div>
	</div>
<?php echo form_close() ?>      
       