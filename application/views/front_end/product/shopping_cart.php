<?php echo form_open('product/checkout', array('id' => 'checkout_input_form','class'=>'form-horizontal')) ?>
<?php echo form_hidden('base_url', base_url()) ?>
<h3><?php echo $table_title ?></h3>
<?php if (isset($shopping_cart_list)) : ?>
	<table class="table table-hover table-bordered">
		<tr class="info">
			<th>Product Image</th>
			<th>Category Name</th>
			<th>Product Name</th>
			<th>Quantity</th>
                        <th>Unit Price</th>
			<th>Quantity Price</th>
			<th>Action</th>
		</tr>
<?php $total_items = 0 ?>
<?php $total_price = 0 ?>
<?php foreach($shopping_cart_list as $row): ?>
		<tr class="info">
			<td>
                            <?php 
                                $img_flag = 0;
                                $image_data = $this->common_model->query_single_row_by_single_source('boutique_product_images', 'product_id', $row->product_id);
                                if ( count($image_data) > 0 ) :
                                    $img_flag = 1;
                                    foreach ($image_data as $img) :
                                        $image_file   = $img->file_name;
                                        $dimension    = explode('X', $img->dimension);
                                        $image_width  = ($dimension[0] <= 150) ? $dimension[0] : 150;
                                        $image_height = $dimension[1];
                                    endforeach; 
                                    
                                    $quantity_price = $row->quantity * $row->unit_price;
                                    $total_price   += $quantity_price;
                                    $total_items   += $row->quantity;
                            ?>
                            <img src="assets/uploads/product_images/<?php echo $image_file ?>" alt="" class="img-rounded" width="<?php echo $image_width ?>" height="<?php echo $image_height ?>" />
                            <?php endif ?>
                        </td>
			<td> <?php echo $row->name ?></td>
			<td> <?php echo $row->product_name ?></td>
			<td> <?php echo $row->quantity ?></td>
                        <td> <?php printf("%.2f", $row->unit_price) ?></td>
			<td> <?php printf("%.2f", $quantity_price) ?></td>
			<td>
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="return delete_checked_item('Are you sure you want to remove <?php echo $row->product_name ?>','<?php echo base_url() ?>','<?php echo $row->shopping_cart_id ?>') "><i class="icon-remove"></i> Remove</a>
                        </td>
		</tr>
<?php endforeach ?>
                <tr>
                    <td colspan="3" align="right"></td>
                    <td><strong><?php echo $total_items ?></strong></td>
                    <td align="right"></td>
                    <td><strong><?php printf("%.2f", $total_price) ?></strong></td>
                    <td></td>
                </tr>
		</table>	
<?php endif;?>	
	<p>
            <?php if (isset($category_id)) : ?>
                <a href="product/display/<?php echo $category_id ?>" class="btn btn-primary">Continue Shopping</a>
            <?php endif ?>
            <button  class="btn btn-primary btn-success" type="submit">Proceed to Checkout</button>
	</p>
<?php echo form_close() ?>