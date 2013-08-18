<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php echo form_hidden('base_url', base_url()) ?>
       
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label>Subject Heading</label>
                <select name="subject_heading" class="small-input" id="subject_heading">                    
                    <option value="" selected="selected">----Choose----</option>
                    <option value="customer_service">Customer Service</option>
                    <option value="webmaster" >Webmaster</option>
                </select> 
            </p>

            <p>
                <label for="e_mail_address">E-mail address</label>
                <?php echo form_input(array('name' => 'e_mail_address', 'id' => 'e_mail_address', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($e_mail_address) ? $e_mail_address : set_value('e_mail_address'))) ?>
                <?php echo form_error('e_mail_address', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="order_id">Order ID</label>
                <?php echo form_input(array('name' => 'order_id', 'id' => 'order_id', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($order_id) ? $order_id : set_value('order_id'))) ?>
                <?php echo form_error('order_id', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="fileUpload">Attach File</label>
                <?php echo form_hidden('MAX_FILE_SIZE', '2000000') ?>
                <?php echo form_input(array('name' => 'fileUpload', 'id' => 'fileUpload', 'class' => 'text-input small-input', 'type' => 'file')) ?>
            </p>
            
            <p>
                <label for="message">Message</label>
                <textarea cols="20" rows="15" name="message" id="message" style="width: 246px; height: 188px;"></textarea>
            </p>
            
            <p>
                <?php echo form_submit(array('name' => 'submit_other_payment_input', 'id' => 'submit_other_payment_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>