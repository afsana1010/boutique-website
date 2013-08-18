<div class="content-box-header">
    <h3><?php echo $form_title; ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php if ($action == 'edit'): ?>    
        <?php echo form_open('product_stock/manage/' . $id, array('id' => 'stock_input_form')) ?>
    <?php else : ?>
        <?php echo form_open('product_stock/manage', array('id' => 'stock_input_form')) ?>
    <?php endif ?>
        
       <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
            <p>
                <label for="product_name">Product Name </label> 
                <?php echo form_input(array('name' => 'product_name', 'id' => 'product_name', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($product_name) ? $product_name : set_value('product_name'))) ?>
                <?php echo form_error('product_name', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="quantity">Quantity </label> 
                <?php echo form_input(array('name' => 'quantity', 'id' => 'quantity', 'class' => 'text-input small-input', 'value' => isset($quantity) ? $quantity : set_value('quantity'))) ?>
                <?php echo "<br /><small>should be a non-decimal value like 1500, 700, etc.</strong></small>" ?>
                <?php echo form_error('quantity', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <label for="amount">Purchased Amount(SGD) </label> 
                <?php echo form_input(array('name' => 'amount', 'id' => 'amount', 'class' => 'text-input small-input', 'value' => isset($amount) ? $amount : set_value('amount'))) ?>
                <?php echo "<br /><small>should be a decimal value like 45.95, 789.00, etc.</strong></small>" ?>
                <?php echo form_error('amount', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>
            
            <p>
                <label for="brought_from">Bought From </label>
                <?php echo form_input(array('name' => 'brought_from', 'id' => 'brought_from', 'class' => 'text-input small-input', 'maxlength' => '60', 'value' => isset($brought_from) ? $brought_from : set_value('brought_from'))) ?>
                <?php echo "<br /><small>provide the sellr's name or the company name from where you purchased the product</strong></small>" ?>
                <?php echo form_error('brought_from', '<span class="input-notification error png_bg">', '</span>') ?>
            </p>

            <p>
                <?php echo form_submit(array('name' => 'submit_stock_input', 'id' => 'submit_stock_input', 'class' => 'button'), 'Submit') ?>
            </p>
        </fieldset>     
        
        <div class="clear"></div><!-- End .clear -->

        <?php echo form_close() ?>
    </div>        
</div>