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
        
       <fieldset>
            <?php if (!isset($action_name)): ?>
            <p>
                <label for="action_name">Action Name </label> 
                <?php echo form_input(array('name'      => 'action_name', 
                                            'id'        => 'action_name', 'class' => 'text-input small-input', 
                                            'maxlength' => '60',          'value' => set_value('action_name'))) ?>
                <?php echo form_error('action_name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            <?php endif ?>

            <p>
                <label for="message">Message </label> 
                <?php echo form_textarea(array('name'  => 'message', 
                                               'id'    => 'message', 'class' => 'text-input textarea',
                                               'cols'  =>'22','rows'=>'10',
                                               'value' => isset($message) ? $message : set_value('message'))) ?>
                <?php echo "<br /><small><ul>" ?>
                <?php echo "<li>DO NOT provide any special characters.</li>" ?>
                <?php echo "<li>Submit as much as shorter message when it is SMS.</li>" ?>
                <?php echo "<li>Put <strong>2FA</strong> to mention the 4-digit code which is used to complete registration.</li>" ?>
                <?php echo "<li>Put <strong>COMPANY</strong> at the place where you want to mention the name of the company(i.e, Boutique).</li>" ?>
                <?php echo "<li>Put <strong>NAME</strong> at the place where you want to mention sender's name in the message-body.</li>" ?>
                <?php echo "<li>Put <strong>FORGOTPASSWORD</strong> at the place where you want to mention user's new password.</li>" ?>
                <?php echo "<li>Put <strong>NUMBER</strong> at the place where you want to mention consignment-number/bill-number/shipment-track.</li>" ?>
                <?php echo "<li>Put <strong>COURIER</strong> at the place where you want to mention courier information used to deliver an order.</li>" ?>
                <?php echo "<li>Put <strong>DATE</strong> at the place where you want to mention any date, can be like a delivery date.</li>" ?>
                <?php echo "</ul></small>" ?>
                <?php echo form_error('message', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
	
            <?php if (!isset($message_media)): ?>
            <p>
                <label for="message_media">Email/SMS </label>
                <?php if (isset($message_media)): ?>
                    <?php if ($message_media == 'email'): ?>
                        <?php $check_sms   = 'FALSE' ?>
                        <?php $check_email = 'TRUE' ?>
                        <?php $check_both  = 'FALSE' ?>
                    <?php elseif ($message_media == 'sms'): ?>
                        <?php $check_sms   = 'TRUE' ?>
                        <?php $check_email = 'FALSE' ?>
                        <?php $check_both  = 'FALSE' ?>
                    <?php elseif ($message_media == 'both'): ?>
                        <?php $check_sms   = 'FALSE' ?>
                        <?php $check_email = 'FALSE' ?>
                        <?php $check_both  = 'TRUE' ?>
                    <?php endif ?>
                    <?php else: ?>
                        <?php $check_sms   = 'FALSE' ?>
                        <?php $check_email = 'FALSE' ?>
                        <?php $check_both  = 'TRUE' ?> 
                <?php endif ?>

                <?php echo form_radio(array('name' => 'message_media', 'id' => 'is_email', 'value' => 'email', 'checked' => $check_email)) . '&nbsp;Email&nbsp;&nbsp;' ?>
                <?php echo form_radio(array('name' => 'message_media', 'id' => 'is_sms',   'value' => 'sms', 'checked' => $check_sms)) . '&nbsp;SMS&nbsp;&nbsp;' ?>
                <?php echo form_radio(array('name' => 'message_media', 'id' => 'is_both',   'value' => 'both', 'checked' => $check_both)) . '&nbsp;Both' ?>
            </p>
            <?php endif ?>
            
            <p>
                <?php echo form_submit(array('name' => 'submit_message_input', 'id' => 'submit_message_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>