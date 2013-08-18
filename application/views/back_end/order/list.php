<?php
if (isset($all_order['order_afterPg'])) :
    $num_of_orders = count($all_order['order_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_order['order_afterPg']) && $num_of_orders > 0) : ?>
            <?php echo form_open('order/manage', array('id' => 'list_order')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = update/view details; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="order_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th><a href="javascript:void(0);">S.No.</a></th>
                            <th><a href="javascript:void(0);">Date</a></th>
                            <th><a href="javascript:void(0);">Consignment No.</a></th>
                            <th><a href="javascript:void(0);">Member Name</a></th>
                            <th><a href="javascript:void(0);">Product Name</a></th>
                            <th><a href="javascript:void(0);">Quantity</a></th>
                            <th><a href="javascript:void(0);">Price</a></th>
                            <th><a href="javascript:void(0);">Status</a></th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pagination">
    <?php echo $order_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
	<?php $loopcount=0; ?>
    <?php foreach ($all_order['order_afterPg'] as $rows_order) : ?>
                            <tr>
                                <td><?php $loopcount++; echo $loopcount ?></td>
                                <td><?php echo $rows_order->order_date ?></td>
                                <td><?php echo $rows_order->bill_no ?></td>
                                <td><?php echo $rows_order->member_name ?></td>
                                <td><?php echo $rows_order->product_name ?></td>
                                <td><?php echo $rows_order->order_quantity ?></td>
                                <td><?php echo $rows_order->order_quantity * $rows_order->unit_price ?></td>
                                <td><?php if($rows_order->is_open==1): echo "Open";  else : echo "Close"; endif;?></td>
				<td>
                                    <?php if($rows_order->is_open==1):?>
                                    <!-- Icons -->
                                    <a href="order/manage/<?php echo $rows_order->id ?>" title="Update">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Update" />
                                    </a>
                                    <?php endif;?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="order" />
                <input type="hidden" id="order_deletion_type" name="order_deletion_type" value="" />
                <input type="hidden" id="single_order_id" name="single_order_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = update/view details; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No orders found yet</div>
            </div>
            <div class="clear"></div>
<?php endif ?>
    </div>        
</div>