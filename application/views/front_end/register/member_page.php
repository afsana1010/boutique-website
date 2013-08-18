<h3><?php echo $form_title ?></h3>

<?php if ( (isset($user_order)) && (count($user_order) > 0) ) : ?>
<center>
    <h4><?php echo "My Orders" ?></h4>
</center>
<table class="table table-bordered">
    <tr>
        <td>Date</td>
        <td>Bil No</td>
        <td>Product Name</td>
        <td>Quantity</td>
        <td>Status</td>
    </tr>
    <?php $loopcount=0; $total=0.00; $quantity=0; ?>
    <?php foreach($user_order as $row): ?>	
    <tr>
        <td><?php echo date('F j, Y', strtotime($row->order_date)) ?></td>
        <td><?php echo $row->bill_no ?></td>
        <td><?php echo $row->product_name ?></td>
        <td><?php echo $row->order_quantity ?></td>
        <td>
            <?php echo $row->level_status_message ?>
            <?php if ($row->shipment_level == 2) : ?>
                ,&nbsp;<u>Courier Name: </u><strong><?php echo $row->courier_name ?></strong>;
                <u>Courier No.: </u><strong><?php echo $row->courier_no ?></strong>
            <?php endif ?>     
            <?php if ($row->shipment_level == 3): ?>
                <strong><?php echo date('F j, Y', strtotime($row->delivered_on)) ?></strong>
            <?php endif ?>    
            
        </td>
    </tr>	
    <?php endforeach;?>
</table>
<?php else : ?>
    <p class="text-warning">You don't have any order yet. Please select any category from the above to start shopping.</p>
<?php endif;?>	