<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php if ($action == 'edit'): ?>    
        <?php echo form_open('country_code/manage/' . $id, array('id' => 'country_code_input_form')) ?>
    <?php else : ?>
        <?php echo form_open('country_code/manage', array('id' => 'country_code_input_form')) ?>
    <?php endif ?>
        
       <fieldset>
            <p>
                <label for="name">Country</label> 
                <?php echo form_input(array('name' => 'country', 'id' => 'country', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($country) ? $country : set_value('country'))) ?>
                <?php echo form_error('name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label for="code">Code</label> 
                <?php echo form_input(array('name' => 'code', 'id' => 'code', 'class' => 'text-input small-input', 'maxlength' => '6', 'value' => isset($code) ? $code : set_value('code'))) ?>
                <?php echo form_error('name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <?php echo form_submit(array('name' => 'submit_stock_input', 'id' => 'submit_stock_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>