<?php //echo form_open('product/confirmation', array('id' => 'confirmation_input_form', 'class' => 'form-horizontal')) ?>
<?php echo form_open('product/goto_paypal', array('id' => 'confirmation_input_form', 'class' => 'form-horizontal')) ?>
<h3><?php echo $table_title ?></h3>
<?php if (isset($chechout_list)) : ?>
    <table class="table table-bordered">
        <tr>
            <td><u>S/N</u></td>
            <td><u>Item</u></td>
            <td><u>Category</u></td>
            <td><u>Quantity</u></td>
            <td><u>Unit Price(SGD)</u></td>
            <td><u>Quantity Amount(SGD)</u></td>
        </tr>
        <?php 
            $loopcount        = 0;
            $total            = 0.00;
            $quantity         = 0;
            $shopping_cart_id = '';
        ?>
        <?php foreach ($chechout_list as $row): ?>
            <?php 
                $loopcount        ++;
                $total            += $row->unit_price * $row->quantity;
                $quantity         += $row->quantity; 
                $shopping_cart_id = $row->shopping_cart_id;
            ?>		
            <tr>
                <td>
                    <?php echo $loopcount ?>
                </td>
                <td>
                    <?php echo $row->product_name ?>
                </td>
                <td>
                    <?php echo $row->name ?>
                </td>
                <td>
                    <?php echo $row->quantity ?>
                </td>
                <td>
                    <?php echo $row->unit_price ?>
                </td>
                <td>
                    <?php printf("%.2f", $row->quantity * $row->unit_price) ?>
                    <?php echo form_hidden('cart_id[]', $shopping_cart_id) ?>
                </td>
            </tr>		
    <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>TOTAL</strong></td>
            <td><strong><?php echo $quantity; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php printf("%.2f", $total) ?></strong></td>
        </tr>
    </table>
<?php endif; ?>	
<p>
    <button  class="btn btn-primary btn-success" type="submit">Confirm Order</button>
</p>
<?php echo form_close() ?>