<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php if ($action == 'edit'): ?>    
        <?php echo form_open('message/manage/' . $id, array('id' => 'message_input_form')) ?>
    <?php else : ?>
        <?php echo form_open('message/manage', array('id' => 'message_input_form')) ?>
    <?php endif ?>
        
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label for="action_name">Action Name </label> 
                <?php echo form_input(array('name' => 'action_name', 
				'id' => 'action_name', 'class' => 'text-input small-input', 
				'maxlength' => '60', 'value' => isset($action_name) ? $action_name : set_value('action_name'))) ?>
                <?php echo form_error('action_name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="message">Message </label> 
                <?php echo form_textarea(array('name' => 'message', 
				'id' => 'message', 'class' => 'text-input textarea wysiwyg',
				'cols'=>'22','rows'=>'10',
				'value' => isset($message) ? $message : set_value('message'))) ?>
                <?php //echo "<br /><small>should be a text value like  etc.</strong></small>" ?>
                <?php echo form_error('message', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
	
            <p>
                <label for="is_email">Email/SMS </label>
                <?php if ((isset($is_email)) && ($is_email == 0)) : ?>
                    <?php $check_sms = 'TRUE' ?>
					<?php $check_email   = 'FALSE' ?>
                <?php elseif ((isset($is_email)) && ($is_email == 1)) : ?>
                    <?php $check_sms   = 'FALSE' ?>
                    <?php $check_email = 'TRUE' ?>
                <?php else : ?>
                    <?php $check_sms   = 'TRUE' ?>
                    <?php $check_email = 'FALSE' ?>
                <?php endif ?>

                <?php echo form_radio(array('name' => 'is_email', 'id' => 'is_email', 'value' => '1', 'checked' => $check_email)) . '&nbsp;Email&nbsp;&nbsp;' ?>
                <?php echo form_radio(array('name' => 'is_email', 'id' => 'is_sms', 'value' => '0', 'checked' => $check_sms)) . 'SMS' ?>
            </p>
            
            <p>
                <?php echo form_submit(array('name' => 'submit_message_input', 'id' => 'submit_message_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>