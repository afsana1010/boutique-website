<?php
if (isset($all_inventory['inventory_afterPg'])) :
    $num_of_inventorys = count($all_inventory['inventory_afterPg']);
endif;

$this->load->model(array('inventory_model'));
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_inventory['inventory_afterPg']) && $num_of_inventorys > 0) : ?>
            <?php echo form_open('inventory/delete', array('id' => 'list_inventory')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <hr />
                <table id="inventory_table" class='tablesorter'>
                    <thead>
						<?php $slno=0;?>
                        <tr>
                            <th><a href="javascript:void(0);">Sl No.</a></th>
                            <th><a href="javascript:void(0);">Date</a></th>
                            <th><a href="javascript:void(0);">Product Name</a></th>
                            <th><a href="javascript:void(0);">Total</a></th>
                            <th><a href="javascript:void(0);">Sold</a></th>
                            <th><a href="javascript:void(0);">Stock In Hand</a></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pagination">
                                    <?php echo $inventory_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_inventory['inventory_afterPg'] as $rows_inventory) : ?>                            
                            <?php $total_sold    = $this->inventory_model->get_total_sold_products($rows_inventory->id);?>
                            <?php $stock_in_hand = $rows_inventory->quantity - $total_sold; ?>
                            <tr>
                                <td><?php $slno++; echo $slno ?></td>
                                <td><?php echo date('F j, Y', strtotime($rows_inventory->created_at)) ?></td>
                                <td><?php echo $rows_inventory->product_name ?></td>
                                <td><?php echo $rows_inventory->quantity ?></td>
                                <td><?php echo $total_sold ?></td>
                                <td><?php echo $stock_in_hand ?></td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No inventorys found yet</div>
            </div>
            <div class="clear"></div>
<?php endif ?>
    </div>        
</div>