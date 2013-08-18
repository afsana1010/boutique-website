<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
        <?php 
            $current_controller = $this->router->fetch_class(); 
            $current_method     = $this->router->fetch_method();
        ?>
        <?php if ($current_controller == 'payment' && $current_method == 'selection_date' && $method_name=='product_reciept'):?>
        <?php echo form_open('payment/payments/', array('id' => 'product_reciept_input_form')) ?>        
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