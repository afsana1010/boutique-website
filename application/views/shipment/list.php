<?php
if (isset($all_shipment['shipment_afterPg'])) :
    $num_of_shipments = count($all_shipment['shipment_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_shipment['shipment_afterPg']) && $num_of_shipments > 0) : ?>
            <?php echo form_open('shipment/delete', array('id' => 'list_shipment')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = update/view details; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="shipment_table" class='tablesorter'>
                    <thead>
                        <tr>
						    <th>
                                <input type="checkbox" class="check-all" id='check_all_messages' name='check_all_messages' />
                            </th>
                            <th><a href="javascript:void(0);">Level No.</a></th>
                            <th><a href="javascript:void(0);">Shipment Level Status Message</a></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="bulk-actions align-left">
									<a class="button" id="delete_shipment" href="javascript:void(0)" onclick="delete_checked_shipments();">Delete selected</a>&nbsp;
                                    <a href="shipment/manage" class="button">Add New shipment</a>
                                </div>
                                <div class="pagination">
    <?php echo $shipment_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
	<?php $loopcount=0; ?>
    <?php foreach ($all_shipment['shipment_afterPg'] as $rows_shipment) : ?>
                            <tr>
                                <td><input type="checkbox" name="shipment_id[]" value="<?php echo $rows_shipment->id ?>" /></td>
								<td><?php $loopcount++; echo "Level - ".$loopcount ?></td>
                                <td><?php echo $rows_shipment->level_status_message ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="shipment/manage/<?php echo $rows_shipment->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <a href="javascript:void(0)" title="Delete" onclick="return delete_checked_shipment('Are you sure you want to delete <?php echo $rows_shipment->level_status_message ?>','shipment_deletion_type','list_shipment','<?php echo $rows_shipment->id ?>') ">
                                        <img src="assets/images/admin/icons/cross.png" alt="Delete" />
                                    </a>									
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="shipment" />
                <input type="hidden" id="shipment_deletion_type" name="shipment_deletion_type" value="" />
                <input type="hidden" id="single_shipment_id" name="single_shipment_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = update/view details; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No shipments found yet</div>
            </div>
            <div class="clear"></div>
            <a href="shipment/manage" class="button">Add New shipment</a>
<?php endif ?>
    </div>        
</div>