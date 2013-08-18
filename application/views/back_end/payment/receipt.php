<?php
if (isset($all_payment['payment_afterPg'])) :
    $num_of_payments = count($all_payment['payment_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_payment['payment_afterPg']) && $num_of_payments > 0) : ?>
            <?php echo form_open('', array('id' => 'list_payment')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <hr />
                <table id="payment_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th><a href="javascript:void(0);">Date</a></th>
							<th><a href="javascript:void(0);">Product Name</a></th>
                            <th><a href="javascript:void(0);">Quantity</a></th>
                            <th><a href="javascript:void(0);">Amount</a></th>
							<th><a href="javascript:void(0);">Bill No.</a></th>
                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pagination">
    <?php echo $payment_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_payment['payment_afterPg'] as $rows_payment) : ?>
                            <tr>
                                <td><?php echo date('F j, Y', strtotime($rows_payment->created_at)) ?></td>
								<td><?php echo $rows_payment->product_name ?></td>
                                <td><?php echo $rows_payment->quantity ?></td>
                                <td><?php echo $rows_payment->amount ?></td>
                                <td><?php echo $rows_payment->bill_no ?></td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <hr />
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No payments found yet</div>
            </div>
            <div class="clear"></div>
<?php endif ?>
    </div>        
</div>