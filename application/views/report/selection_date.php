<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<?php if(isset($error_message)):?>
<div class="notification attention png_bg">
        <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
    <div><?php echo $error_message ?></div>
</div>
<div class="clear"></div>
<?php endif;?>
<div class="content-box-content">
    <div class="tab-content default-tab">
        <?php 
            $current_controller = $this->router->fetch_class(); 
            //$current_method     = $this->router->fetch_method();
        ?>
        <?php if ($current_controller == 'generate_downloadable_report'  && $method_name=='member_management'):?>
        <?php echo form_open('generate_downloadable_report/member_management/', array('id' => 'member_input_form')) ?>
        <?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='category_management'):?>
        <?php echo form_open('generate_downloadable_report/category_management/', array('id' => 'category_input_form')) ?>
        <?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='product_management'):?>
        <?php echo form_open('generate_downloadable_report/product_management/', array('id' => 'product_input_form')) ?>
        <?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='inventory_management'):?>
        <?php echo form_open('generate_downloadable_report/inventory_management/', array('id' => 'inventory_input_form')) ?>
        <?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='order_management'):?>
        <?php echo form_open('generate_downloadable_report/order_management/', array('id' => 'order_input_form')) ?>        
        <?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='shipment_tracking_management'):?>
        <?php echo form_open('generate_downloadable_report/shipment_tracking_management/', array('id' => 'shipment_tracking_input_form')) ?>         
        <?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='advertisement_management'):?>
        <?php echo form_open('generate_downloadable_report/advertisement_management/', array('id' => 'advertisement_input_form')) ?>         
        <?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='stock_management'):?>
        <?php echo form_open('generate_downloadable_report/stock_management/', array('id' => 'stock_input_form')) ?>        
		<?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='general_payments_management'):?>
        <?php echo form_open('generate_downloadable_report/general_payments_management/', array('id' => 'general_payments_input_form')) ?>         
		<?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='other_payments_management'):?>
        <?php echo form_open('generate_downloadable_report/other_payments_management/', array('id' => 'other_payments_input_form')) ?>         
		<?php elseif ($current_controller == 'generate_downloadable_report'  && $method_name=='profit_loss_management'):?>
        <?php echo form_open('generate_downloadable_report/profit_loss_management/', array('id' => 'profit_loss_input_form')) ?>         
		<?php endif;?>
        
        <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->            
            <p>
                <label for="from_date">From Date </label> 
                <?php echo form_input(array('name' => 'from_date', 'id' => 'from_date', 'class' => 'text-input small-input', 'readonly' => 'true', 'maxlength' => '45', 'value' => isset($from_date) ? $from_date : set_value('from_date'))) ?>
                <?php echo form_error('from_date', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="to_date">To Date </label> 
                <?php echo form_input(array('name' => 'to_date', 'id' => 'to_date', 'class' => 'text-input small-input', 'readonly' => 'true', 'maxlength' => '45', 'value' => isset($to_date) ? $to_date : set_value('to_date'))) ?>
                <?php echo form_error('to_date', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <?php echo form_submit(array('name' => 'submit_search_input', 'id' => 'submit_search_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>
        <div class="clear"></div><!-- End .clear -->
        <?php echo form_close();?>
    </div>        
</div>