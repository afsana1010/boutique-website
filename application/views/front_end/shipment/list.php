<?php
if (isset($shipment_record)) :
    $num_of_shipments = count($shipment_record);
endif;
?>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
        <?php if (isset($shipment_record) && $num_of_shipments > 0) : ?>
            <?php //echo"<pre>"; print_r($shipment_record);die();?>
            <?php echo form_hidden('base_url', base_url()) ?>
            <table class="table table-bordered">
                <tr class="row">
                    <th><a href="javascript:void(0);">Product Name</a></th>
                    <th><a href="javascript:void(0);">Shipment Status</a></th>
                </tr>
                <?php foreach ($shipment_record as $rows_shipment) : ?>
                    <tr class="row">
                        <td><?php echo $rows_shipment->product_name ?></td>
                        <td>
                            <?php
                            if ($rows_shipment->shipment_level_id == 1):
                                echo $rows_shipment->level_status_message;
                            elseif ($rows_shipment->shipment_level_id == 2):
                                echo $rows_shipment->level_status_message . " " . $rows_shipment->courier_name . " and the track no. is " . $rows_shipment->courier_no;
                            elseif ($rows_shipment->shipment_level_id == 3):
                                echo $rows_shipment->level_status_message . " " . date('F j, Y', strtotime($rows_shipment->delivered_on));
                            endif;
                            ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php else : ?>
            <div class="notification attention png_bg">
                    <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
                <div>No shipments found yet</div>
            </div>
            <div class="clear"></div>
        <?php endif ?>
    </div>        
</div>