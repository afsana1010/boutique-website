<?php
if (isset($all_advertisement['staff_afterPg'])) :
    $num_of_advertisements = count($all_advertisement['advertisement_afterPg']);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
<?php if (isset($all_advertisement['advertisement_afterPg']) && $num_of_advertisements > 0) : ?>
            <?php echo form_open('advertisement/delete', array('id' => 'list_advertisement')) ?> 
                <?php echo form_hidden('base_url', base_url()) ?>

                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <i>click on the green headers to sort data</i> ]
                </div>
                <hr />
                <table id="advertisement_table" class='tablesorter'>
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="check-all" id='check_all_advertisements' name='check_all_advertisements' />
                            </th>
                            <th><a href="javascript:void(0);">Customer Name</a></th>
                            <th><a href="javascript:void(0);">Advertisement Position</a></th>
                            <th><a href="javascript:void(0);">Period</a></th>
                            <th><a href="javascript:void(0);">Expires on</a></th>
							<th><a href="javascript:void(0);">Status</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="bulk-actions align-left">
                                    <a href="advertisement/manage" class="button">Add New advertisement</a>
                                </div>
                                <div class="pagination">
    <?php echo $advertisement_paging; ?>
                                </div> <!-- End .pagination -->
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
    <?php foreach ($all_advertisement['advertisement_afterPg'] as $rows_advertisement) : ?>
    <?php
        $interval=''; 
        if($rows_advertisement->selected_period_unit=='day')
            $interval = ' +'.(string)$rows_advertisement->selected_period." days";
        elseif($rows_advertisement->selected_period_unit=='month')
            $interval = ' +'.(string)$rows_advertisement->selected_period." months";
        elseif($rows_advertisement->selected_period_unit=='year')
            $interval = ' +'.(string)$rows_advertisement->selected_period." years";

        $date = $rows_advertisement->run_from;
        $expire_on = strtotime(date("Y-m-d", strtotime($date)) . $interval);
        
    ?>
                            <tr>
                                <td><input type="checkbox" name="advertisement_id[]" value="<?php echo $rows_advertisement->id ?>" /></td>
                                <td><?php echo $rows_advertisement->customer_name ?></td>
                                <td><?php echo $rows_advertisement->selected_position ?></td>
                                <td><?php echo $rows_advertisement->selected_period." ".$rows_advertisement->selected_period_unit ?></td>
                                <td><?php echo date('F j, Y', $expire_on) ?></td>
                                <td><?php if($rows_advertisement->run_from > date('y-m-d')) echo "Active"; else echo "Inactive"; ?></td>
                                <td>
                                    <a href="advertisement/manage/<?php echo $rows_advertisement->id ?>" title="Edit">		
                                        <img src="assets/images/admin/icons/pencil.png" alt="Edit" />
                                    </a>
                                </td>
                            </tr>
                                <?php endforeach ?>
                    </tbody>
                </table>
                <input type="hidden" name="oper" value="delete" />
                <input type="hidden" name="item_type" value="advertisement" />
                <input type="hidden" id="advertisement_deletion_type" name="advertisement_deletion_type" value="" />
                <input type="hidden" id="single_advertisement_id" name="single_advertisement_id" value="" />
                <hr />
                <div>
                    [ <img src="assets/images/admin/icons/pencil.png" /> = edit/view details; <i>click on the green headers to sort data</i> ]
                </div>
            <?php echo form_close() ?>
<?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No advertisements found yet</div>
            </div>
            <div class="clear"></div>
            <a href="advertisement_product/manage" class="button">Add New advertisement</a>
<?php endif ?>
    </div>        
</div>