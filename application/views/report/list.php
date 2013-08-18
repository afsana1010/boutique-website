
<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<?php if(isset($error_message)):?>
<div class="notification attention png_bg">
        <!--<a href="#" class="close"><img src="webroot/images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>-->
    <div><?php echo $error_message ?></div>
</div>
<div class="clear"></div>
<?php endif;?>

<div class="content-box-content">
    <div class="tab-content default-tab">
    <?php echo form_hidden('base_url', base_url()) ?>

   <table id="report_table" class='tablesorter'>
        <tbody>
            <tr><td><a href="generate_downloadable_report/selection_date/member_management">Member Management</a></td></tr>
            <tr><td><a href="generate_downloadable_report/selection_date/category_management">Category Management</a></td></tr>
            <tr><td><a href="generate_downloadable_report/selection_date/product_management">Product Management</a></td></tr>
            <tr><td><a href="generate_downloadable_report/selection_date/inventory_management">Inventory Management</a></td></tr>
            <tr><td><a href="generate_downloadable_report/selection_date/order_management">Order Management</a></td></tr>
            <tr><td><a href="generate_downloadable_report/selection_date/shipment_tracking_management">Shipment Tracking Management</a></td></tr>
            <tr><td><a href="generate_downloadable_report/selection_date/advertisement_management">Advertisement Management</a></td></tr>       
            <tr><td>Stock &  Payment Management
					[<a href="generate_downloadable_report/selection_date/stock_management">Stock Management</a>
					<a href="generate_downloadable_report/selection_date/general_payments_management">Payment Management</a>
					<a href="generate_downloadable_report/selection_date/other_payments_management">Other Payment Management</a>]
				</td>
			</tr>
			<tr><td>Accounts Management
					[<a href="generate_downloadable_report/selection_date/stock_management">Stock Management</a>
					<a href="generate_downloadable_report/selection_date/general_payments_management">Payment Management</a>
					<a href="generate_downloadable_report/selection_date/other_payments_management">Other Payment Management</a>]
				</td>
			</tr>
            <tr><td><a href="generate_downloadable_report/selection_date/profit_loss_management">P&L Statement</a></td></tr>
        </tbody>
    </table>

    </div>        
</div>