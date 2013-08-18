<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php if ($action == 'edit'): ?>    
        <?php echo form_open('shipment/manage/' . $id, array('id' => 'shipment_input_form')) ?>
    <?php else : ?>
        <?php echo form_open('shipment/manage', array('id' => 'shipment_input_form')) ?>
    <?php endif ?>
        
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label for="level_status_message">Shipment Level Status Message </label>
				<?php echo form_input(array('name' => 'level_status_message', 'id' => 'level_status_message', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($level_status_message) ? $level_status_message : set_value('level_status_message'))) ?>
                <?php echo form_error('level_status_message', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <?php echo form_submit(array('name' => 'submit_shipment_input', 'id' => 'submit_shipment_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>