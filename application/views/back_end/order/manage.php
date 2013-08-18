<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
    <h3><?php $courier_name="";$courier_no="";$delieverd_on=""; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php if ($action == 'edit'): ?>    
        <?php echo form_open('order/manage/' . $id, array('id' => 'order_input_form')) ?>
    <?php endif ?>
        
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <?php if($shipment_level_id==1):?>
			<?php echo form_hidden('shipment_level_id',2) ?>
			<p>
                <label for="courier_name">Courier Name</label> 
                <?php echo form_input(array('name' => 'courier_name', 'id' => 'courier_name', 'class' => 'text-input small-input', 'maxlength' => '100', 'value' => isset($courier_name) ? $courier_name : set_value('courier_name'))) ?>
                <?php echo form_error('courier_name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="courier_no">Courier No</label> 
                <?php echo form_input(array('name' => 'courier_no', 'id' => 'courier_no', 'class' => 'text-input small-input', 'maxlength' => '80', 'value' => isset($courier_no) ? $courier_no : set_value('courier_no'))) ?>
                <?php echo form_error('email_address', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			<?php endif ?>           

			<?php if($shipment_level_id==2):?>
			<?php echo form_hidden('shipment_level_id',3) ?>
			<p>
                <label for="delieverd_on">Delieverd On</label> 
                <?php echo form_input(array('name' => 'delieverd_on', 'id' => 'delieverd_on', 'class' => 'text-input small-input', 'maxlength' => '100', 'value' => isset($delieverd_on) ? $courier_name : set_value('courier_name'))) ?>
                <?php echo form_error('delieverd_on', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
			<?php endif ?>
            
            <p>
                <?php echo form_submit(array('name' => 'submit_shipment_order_input', 'id' => 'submit_shipment_order_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>