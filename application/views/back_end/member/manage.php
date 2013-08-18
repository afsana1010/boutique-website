<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php if ($action == 'edit'): ?>    
        <?php echo form_open('member/manage/' . $id, array('id' => 'member_input_form')) ?>
    <?php else : ?>
        <?php echo form_open('member/manage', array('id' => 'member_input_form')) ?>
    <?php endif ?>
        
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label for="full_name">Full Name </label> 
                <?php echo form_input(array('name' => 'full_name', 'id' => 'full_name', 'class' => 'text-input small-input', 'maxlength' => '100', 'value' => isset($full_name) ? $full_name : set_value('full_name'))) ?>
                <?php echo form_error('full_name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="email_address">Email Address </label> 
                <?php echo form_input(array('name' => 'email_address', 'id' => 'email_address', 'class' => 'text-input small-input', 'maxlength' => '80', 'value' => isset($email_address) ? $email_address : set_value('email_address'))) ?>
                <?php echo "<br /><small>Will be used to login. Please provide a valid email address.</small>" ?>
                <?php echo form_error('email_address', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <!-- starts password inputs -->
            <?php if ($action == 'edit'): ?>    
                <?php $password_panel = "style='display:none;'"?>
                <?php echo form_checkbox(array('name' => 'change_password', 'id' => 'change_password', 'value' => 'yes', 'checked' => FALSE)) . '&nbsp;<strong>Change Password ?</strong>' ?>
            <?php else : ?>
                <?php $password_panel = "style='display:inline;'"?>
            <?php endif ?>

            <div id="password_panel" <?php echo $password_panel ?>>
                <p>
                    <label for="user_password">Password </label> 
                    <?php echo form_password(array('name' => 'user_password', 'id' => 'user_password', 'class' => 'text-input small-input', 'maxlength' => '100')) ?>
                    <?php echo form_error('user_password', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>
                <p>
                    <label for="password_conf">Confirm Password </label> 
                    <?php echo form_password(array('name' => 'password_conf', 'id' => 'password_conf', 'class' => 'text-input small-input', 'maxlength' => '100')) ?>
                    <?php echo form_error('password_conf', '<span class="input-notification error png_bg">', '</span>') ?>
                </p>
            </div>
            <!-- ends password inputs -->
            
            <p>
                <br />
                <label for="mobile_no">Mobile No </label>
                <?php echo form_input(array('name' => 'mobile_no', 'id' => 'mobile_no', 'class' => 'text-input small-input', 'maxlength' => '20', 'value' => isset($mobile_no) ? $mobile_no : set_value('mobile_no'))) ?>
                <?php echo "<br /><small>Use a valid mobile numbner like <strong>011-65-8??? ???? (or 9??? ????</strong></small>" ?>
                <?php echo form_error('mobile_no', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="residence_address">Residence Address </label>
                <?php echo form_input(array('name' => 'residence_address', 'id' => 'residence_address', 'class' => 'text-input large-input', 'value' => isset($residence_address) ? $residence_address : set_value('residence_address'))) ?>
                <?php echo "<br /><small>Provide address in details with House/Appt./Plot#, Road#, Zipcode, City, Country, etc.</strong></small>" ?>
                <?php echo form_error('residence_address', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="office_address">Office Address </label>
                <?php echo form_input(array('name' => 'office_address', 'id' => 'office_address', 'class' => 'text-input large-input', 'value' => isset($office_address) ? $office_address : set_value('office_address'))) ?>
                <?php echo "<br /><small>Optional Address</strong></small>" ?>
                <?php echo form_error('office_address', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label for="is_residence_preferred_delivery_place">Preferred Delivery Location </label>
                <?php if ((isset($is_residence_preferred_delivery_place)) && ($is_residence_preferred_delivery_place == 0)) : ?>
                    <?php $check_home   = 'FALSE' ?>
                    <?php $check_office = 'TRUE' ?>
                <?php elseif ((isset($is_residence_preferred_delivery_place)) && ($is_residence_preferred_delivery_place == 1)) : ?>
                    <?php $check_home   = 'FALSE' ?>
                    <?php $check_office = 'TRUE' ?>
                <?php else : ?>
                    <?php $check_home   = 'TRUE' ?>
                    <?php $check_office = 'FALSE' ?>
                <?php endif ?>

                <?php echo form_radio(array('name' => 'is_residence_preferred_delivery_place', 'id' => 'is_home_to_deliver', 'value' => '1', 'checked' => $check_home)) . '&nbsp;Home&nbsp;&nbsp;' ?>
                <?php echo form_radio(array('name' => 'is_residence_preferred_delivery_place', 'id' => 'is_office_to_deliver', 'value' => '0', 'checked' => $check_office)) . 'Office' ?>
            </p>

            <p>
                <?php echo form_submit(array('name' => 'submit_member_input', 'id' => 'submit_member_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>