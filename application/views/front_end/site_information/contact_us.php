<legend><h3><?php echo $form_title; ?></h3></legend>
    <?php echo form_open_multipart('site_information/contact_us') ?>
	
    <div class="control-group">
        <label class="control-label" for="subject"><strong>Subject</strong></label>
        <div class="controls">
            <?php $subject_options = array('customer_service' => 'Customer Service', 'webmaster' => 'Webmaster') ?>    
            <?php echo form_dropdown('subject', $subject_options, '0', 'class="small-input"') ?>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" for="from_email"><strong>E-mail address</strong></label>
        <div class="controls">
            <?php echo form_input(array('name' => 'from_email', 'id' => 'from_email', 'maxlength' => '100', 'value' => set_value('from_email'))) ?>
        </div>
    </div>
	
    <div class="control-group">
        <label class="control-label" for="bill_no"><strong>Order ID</strong></label>
        <div class="controls">
            <?php echo form_input(array('name' => 'bill_no', 'id' => 'bill_no', 'maxlength' => '100', 'value' => set_value('bill_no'))) ?>
            <?php echo "<br /><small>type your order consignment number. </small>" ?>
            <?php echo form_error('bill_no', '<span class="help-inline">Please provide consignment number', '</span>') ?>
        </div>
    </div>
	
    <div class="control-group">
        <label class="control-label" for="userfile"><strong>Attachment</strong></label>
        <div class="controls">
            <input id="image_input" name="userfile" type="file" /> 
            <?php echo "<br /><small>Maximum filesize: 1MB. Allowed image files: .jpg, .gif.</strong></small>" ?>
        </div>
    </div>
	
    <div class="control-group">
        <label class="control-label" for="message"><strong>Message</strong></label>
        <div class="controls">
            <?php echo form_textarea(array('name' => 'message', 'id' => 'message', 'style'=>'resize:none','maxlength' => '100', 'value' => set_value('message'))) ?>
            <?php echo form_error('message', '<span class="help-inline">Please provide some message', '</span>') ?>
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