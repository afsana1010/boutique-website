<?php
$current_controller = $this->router->fetch_class();
$current_method = $this->router->fetch_method();
?>
<?php if (($this->session->userdata('logged_in') == true) && (($current_controller == 'siteadmin') && ($current_method == 'index'))): ?>
    <h2>Welcome <?php echo $this->session->userdata('name') ?></h2>
    <p id="page-intro">What would you like to do?</p>

    <div>
        <ul class="shortcut-buttons-set">
            <li>
                <a class="shortcut-button" href="member">
                    <span><img src="assets/images/admin/icons/dashboard/members.jpg" alt="Manage Members" /><br /><br />Members</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="category">
                    <span><img src="assets/images/admin/icons/dashboard/categories.jpg" alt="Manage Product Categories" /><br /><br />Product Categories</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="product">
                    <span><img src="assets/images/admin/icons/dashboard/product.jpg" alt="Manage Products to Display to the Visitors" /><br /><br />Products to Display</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="order">
                    <span><img src="assets/images/admin/icons/dashboard/order.jpg" alt="Manage and Process User Submited Orders" /><br /><br />User Orders</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="clear"></div>
    <br /><br /><br />

    <div>
        <ul class="shortcut-buttons-set">
<!--            <li>
                <a class="shortcut-button" href="product_stock">
                    <span><img src="assets/images/admin/icons/dashboard/stock.jpg" alt="Manage Item Stock" /><br /><br />Item Stock</span>
                </a>
            </li>-->
            <li>
                <a class="shortcut-button" href="shipment">
                    <span><img src="assets/images/admin/icons/dashboard/shipment.jpg" alt="Manage Levels of Shipment" /><br /><br />Shipment Levels</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="inventory">
                    <span><img src="assets/images/admin/icons/dashboard/inventory.jpg" alt="View & Manage Item Stock" /><br /><br />Inventory</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="payment/receipt">
                    <span><img src="assets/images/admin/icons/dashboard/payment.jpg" alt="View Payment History from Different Sources" /><br /><br />Payments</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="profitandloss/selection_date">
                    <span><img src="assets/images/admin/icons/dashboard/loss-n-profit.jpg" alt="Find out Your Loss/Profit" /><br /><br />Profit &amp; Loss</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="clear"></div>
    <br /><br /><br />

    <div>
        <ul class="shortcut-buttons-set">
            <li>
                <a class="shortcut-button" href="generate_downloadable_report/excel">
                    <span><img src="assets/images/admin/icons/dashboard/report.jpg" alt="View Various Reports like Graph and Pie Chart" /><br /><br />Reports</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="advertisement">
                    <span><img src="assets/images/admin/icons/dashboard/advertising.jpg" alt="Manage Advertisements" /><br /><br />Advertisements</span>
                </a>
            </li>
            <li>
                <a class="shortcut-button" href="message">
                    <span><img src="assets/images/admin/icons/dashboard/messages.jpg" alt="Manage SMS and Email Texts" /><br /><br />SMS & Email Messages</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="clear"></div>
    <br /><br /><br />


    <?php
 endif ?>