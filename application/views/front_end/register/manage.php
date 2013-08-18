<legend><h3><?php echo $form_title; ?></h3></legend>
	<?php echo form_open('register', array('id' => 'register_input_form','class'=>'form-horizontal')) ?>
	
    <div class="control-group">
        <label class="control-label" for="full_name">Name</label>
        <div class="controls">
            <?php echo form_input(array('name' => 'full_name', 'id' => 'full_name', 'maxlength' => '100', 'value' => isset($full_name) ? $full_name : set_value('full_name'))) ?>
            <?php echo form_error('full_name', '<span class="help-inline">Please provide your name', '</span>') ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="email_address">Email</label>
        <div class="controls">
            <?php echo form_input(array('name' => 'email_address', 'id' => 'email_address', 'maxlength' => '100', 'value' => isset($email_address) ? $email_address : set_value('email_address'))) ?>
            <?php echo "<br /><small>Will be used to login. Please provide a valid email address.</small>" ?>
            <?php echo form_error('full_name', '<span class="help-inline">Please provide email address', '</span>') ?>
        </div>
    </div>
	
    <div class="control-group">
        <label class="control-label" for="mobile_no">Mobile No</label>
        <div class="controls">
            <?php echo form_input(array('name' => 'mobile_no', 'id' => 'mobile_no', 'maxlength' => '100', 'value' => isset($mobile_no) ? $mobile_no : set_value('mobile_no'))) ?>
            <?php echo "<br /><small>Use a valid and ONLY the Mobile Number like <strong>8??? ???? (or 9??? ????)</strong>;<br />DO NOT INCLUDE THE COUNTRY/AREA CODE. </small>" ?>
            <?php echo form_error('full_name', '<span class="help-inline">Please provide mobile number', '</span>') ?>
        </div>
    </div>
	
    <div class="control-group">
        <label class="control-label" for="residence_address">Residence Address</label>
        <div class="controls">
            <?php echo form_textarea(array('name' => 'residence_address', 'id' => 'residence_address', 'rows'=>'3', 'cols'=>'10', 'style'=>'resize:none','maxlength' => '100', 'value' => isset($residence_address) ? $residence_address : set_value('residence_address'))) ?>
            <?php echo "<br /><small>Provide address in details with House/Appt./Plot#, Road#, Zipcode and City.</strong></small>" ?>
            <?php echo form_error('full_name', '<span class="help-inline">Please provide residence address', '</span>') ?>
        </div>
    </div>
	
	
    <div class="control-group">
        <label class="control-label" for="office_address">Office Address</label>
        <div class="controls">
            <?php echo form_textarea(array('name' => 'office_address', 'id' => 'office_address', 'rows'=>'3', 'cols'=>'10', 'style'=>'resize:none','maxlength' => '100', 'value' => isset($office_address) ? $office_address : set_value('office_address'))) ?>
            <?php echo "<br /><small>Optional Address</strong></small>" ?>
            <?php echo form_error('full_name', '<span class="help-inline">Please provide office address', '</span>') ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="country_code_id">Select Country</label>
        <div class="controls">
            <?php foreach ($country_codes as $code): ?>
                <?php $country_options[$code->id] = $code->country ?>
            <?php endforeach ?>
            <?php echo form_dropdown('country_code_id', $country_options, '0', 'class="small-input"') ?>
        </div>
    </div>
	
    <div class="control-group">
	<label class="control-label" for="is_residence_preferred_delivery_place">Preferred Delivery Place</label>
	<div class="controls">
            <?php echo form_radio(array('name' => 'is_residence_preferred_delivery_place', 'id' => 'is_home_to_deliver', 'class'=>'radio', 'value' => '1', 'checked' => 'checked')) . '&nbsp;Residence&nbsp;&nbsp;' ?>
            <?php echo form_radio(array('name' => 'is_residence_preferred_delivery_place', 'id' => 'is_office_to_deliver', 'class'=>'radio', 'value' => '0', )) . 'Office' ?>
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
       