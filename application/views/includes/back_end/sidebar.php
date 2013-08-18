<?php if ($this->session->userdata('logged_in') == true): ?>
    <?php 
        $current_controller = $this->router->fetch_class(); 
        $current_method     = $this->router->fetch_method();
    ?>
    <div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->

        <h1 id="sidebar-title">
            <a href="javascript:void(0)"><img id="logo" src="assets/images/admin/logo.png" alt="Boutique House Logo" width="221" /></a>
        </h1>
        
        <!-- Sidebar Profile links -->
        <div id="profile-links">
            Hello, <?php echo $this->session->userdata('name'); ?><br /><br />
            <a href="javascript: jQuery.facebox({div:'#change_pass_panel'});" id="change_pass_link">Change Password</a> | <a href="siteadmin/logout" title="Sign Out">Sign Out</a>
        </div>        

        <ul id="main-nav">
            
            <li>
                <a href="siteadmin" class="nav-top-item no-submenu<?php if (($current_controller == 'siteadmin') && ($current_method == 'index')) echo ' current' ?>">
                    Admin Dashboard
                </a>       
            </li>
            
            <li>
                <a href="javascript:void(0)" class="nav-top-item<?php if ($current_controller == 'member') echo ' current' ?>">Manage Members</a>
                <ul>
                    <li><a href="member"<?php if (($current_controller == 'member') && ($current_method == 'index')) echo " class='current'" ?>>View Members</a></li>
                    <li><a href="member/manage"<?php if (($current_controller == 'member') && ($current_method == 'manage')) echo " class='current'" ?>>Add New Member</a></li>
                </ul>       
            </li>
            
            <li>
                <a href="javascript:void(0)" class="nav-top-item<?php if ($current_controller == 'product_section') echo ' current' ?>">Manage Sections</a>
                <ul>
                    <li><a href="product_section"<?php if (($current_controller == 'product_section') && ($current_method == 'index')) echo " class='current'" ?>>View Sections</a></li>
                    <li><a href="product_section/manage"<?php if (($current_controller == 'product_section') && ($current_method == 'manage')) echo " class='current'" ?>>Add New Section</a></li>
                </ul>       
            </li>
            
            <li>
                <a href="javascript:void(0)" class="nav-top-item<?php if ($current_controller == 'category') echo ' current' ?>">Manage Categories</a>
                <ul>
                    <li><a href="category"<?php if (($current_controller == 'category') && ($current_method == 'index')) echo " class='current'" ?>>View Categories</a></li>
                    <li><a href="category/manage"<?php if (($current_controller == 'category') && ($current_method == 'manage')) echo " class='current'" ?>>Add New Category</a></li>
                </ul>       
            </li>
            
            <li>
                <a href="javascript:void(0)" class="nav-top-item<?php if ($current_controller == 'product') echo ' current' ?>">Manage Products</a>
                <ul>
                    <li><a href="product"<?php if (($current_controller == 'product') && ($current_method == 'index')) echo " class='current'" ?>>View Products</a></li>
                    <li><a href="product/manage"<?php if (($current_controller == 'v') && ($current_method == 'manage')) echo " class='current'" ?>>Add New Product</a></li>
                </ul>       
            </li>
			
			<li>
                <a href="order" class="nav-top-item no-submenu<?php if (($current_controller == 'order') && ($current_method == 'index')) echo ' current' ?>">
                    View Orders
                </a>       
            </li>
            
            <li>
                <a href="shipment" class="nav-top-item<?php if ($current_controller == 'shipment') echo ' current' ?>">Manage Shipment Levels</a>
                <ul>
                    <li><a href="shipment"<?php if (($current_controller == 'shipment') && ($current_method == 'index')) echo " class='current'" ?>>View Levels</a></li>
                    <li><a href="shipment/manage"<?php if (($current_controller == 'shipment') && ($current_method == 'manage')) echo " class='current'" ?>>Add New Level</a></li>
                </ul>       
            </li>
            
            <li>
                <a href="product_stock" class="nav-top-item<?php if ($current_controller == 'product_stock') echo ' current' ?>">Manage Item Stock</a>
                <ul>
                    <li><a href="product_stock"<?php if (($current_controller == 'product_stock') && ($current_method == 'index')) echo " class='current'" ?>>Stock List</a></li>
                    <li><a href="product_stock/manage"<?php if (($current_controller == 'product_stock') && ($current_method == 'manage')) echo " class='current'" ?>>Add New Stock</a></li>
                </ul>       
            </li>
			
            <li>
                <a href="inventory" class="nav-top-item no-submenu<?php if (($current_controller == 'inventory') && ($current_method == 'index')) echo ' current' ?>">
                    Inventory
                </a>       
            </li>
            
            <li>
                <a href="payment" class="nav-top-item<?php if ($current_controller == 'payment') echo ' current' ?>">Payments</a>
                <ul>
                    <li><a href="payment/receipt"<?php if (($current_controller == 'payment') && ($current_method == 'index')) echo " class='current'" ?>>Product Receipts</a></li>
                    <li><a href="payment/general_payment"<?php if (($current_controller == 'payment') && ($current_method == 'manage')) echo " class='current'" ?>>General Payments</a></li>
					<li><a href="payment/other_payment"<?php if (($current_controller == 'payment') && ($current_method == 'manageOtherPayment')) echo " class='current'" ?>>Other Payments</a></li>
                </ul>       
            </li>
			<!--
            <li>
                <a href="accounts" class="nav-top-item<?php if ($current_controller == 'accounts') echo ' current' ?>">Accounts</a>
                <ul>
                    <li><a href="accounts/receipt"<?php if (($current_controller == 'accounts') && ($current_method == 'reciept')) echo " class='current'" ?>>Product Reciepts</a></li>
                    <li><a href="accounts/general_payment"<?php if (($current_controller == 'accounts') && ($current_method == 'payment_recie')) echo " class='current'" ?>>Payments Reciepts</a></li>
                    <li><a href="accounts/other_payment"<?php if (($current_controller == 'accounts') && ($current_method == 'manageOtherPayment')) echo " class='current'" ?>>Other Payments Receipts</a></li>
                </ul>       
            </li>
			-->
            <li>
                <a href="profitandloss/selection_date" class="nav-top-item no-submenu<?php if (($current_controller == 'profitandloss') && ($current_method == 'profit_and_loss')) echo ' current' ?>">
                    Profit & Loss Statement
                </a>       
            </li>
            
            <li>
                <a href="advertisement" class="nav-top-item<?php if ($current_controller == 'advertisement') echo ' current' ?>">Manage Advertisements</a>
                <ul>
                    <li><a href="advertisement"<?php if (($current_controller == 'advertisement') && ($current_method == 'index')) echo " class='current'" ?>>Advertisement List</a></li>
                    <li><a href="advertisement/manage"<?php if (($current_controller == 'advertisement') && ($current_method == 'manage')) echo " class='current'" ?>>Create New Advertisement</a></li>
                </ul>       
            </li>
            
            <li>
                <a href="generate_downloadable_report" class="nav-top-item<?php if ($current_controller == 'generate_downloadable_report') echo ' current' ?>">Reports</a>
                <ul>
                    <li><a href="generate_downloadable_report/chart"<?php if (($current_controller == 'generate_downloadable_report') && ($current_method == 'pie_chart')) echo " class='current'" ?>>View Pie Chart</a></li>
                    <li><a href="generate_downloadable_report/excel"<?php if (($current_controller == 'report') && ($current_method == 'excel')) echo " class='current'" ?>>Generate Excel Statement</a></li>
                </ul>       
            </li>
            
            <li>
                <a href="country_code" class="nav-top-item<?php if ($current_controller == 'country_code') echo ' current' ?>">Manage Country Codes</a>
                <ul>
                    <li><a href="country_code"<?php if (($current_controller == 'country_code') && ($current_method == 'index')) echo " class='current'" ?>>Code List</a></li>
                    <li><a href="country_code/manage"<?php if (($current_controller == 'country_code') && ($current_method == 'manage')) echo " class='current'" ?>>Add New Code</a></li>
                </ul>       
            </li>
            
            <!--
            <li>
                <a href="message" class="nav-top-item<?php //if ($current_controller == 'message') echo ' current' ?>">SMS & Email Contents</a>
                <ul>
                    <li><a href="message"<?php //if (($current_controller == 'message') && ($current_method == 'index')) echo " class='current'" ?>>Content List</a></li>
                    <li><a href="message/manage"<?php //if (($current_controller == 'message') && ($current_method == 'manage')) echo " class='current'" ?>>Create New Message</a></li>
                </ul>       
            </li>
            -->
            
            <li>
                <a href="message" class="nav-top-item no-submenu<?php if (($current_controller == 'message') && ($current_method == 'index')) echo ' current' ?>">
                    SMS & Email Contents
                </a>       
            </li>

        </ul> <!-- End #main-nav -->

        <div id="change_pass_panel" style="display:none;">
            <form id="change_pass_input" method="post">
            <?php echo form_open('', array('id' => 'change_pass_input', '' => 'post')) ?>    
                <fieldset>
                    <legend><strong>Want to change password?</strong></legend>
                    <p>
                        <label>Old Password</label>
                        <?php echo form_password(array('name' => 'old_pass', 'class' => 'text-input', 'id' => 'old_pass', 'maxlength' => '15')) ?>
                    </p>
                    <div class="clear"></div>
                    <p>
                        <label>New Password</label>
                        <?php echo form_password(array('name' => 'new_pass', 'class' => 'text-input', 'id' => 'new_pass', 'maxlength' => '15')) ?>
                    </p>
                    <div class="clear"></div>
                    <p>
                        <label>Confirm Password</label>
                        <?php echo form_password(array('name' => 'conf_pass', 'class' => 'text-input', 'class' => 'text-input', 'id' => 'conf_pass', 'maxlength' => '15')) ?>
                    </p>
                    <div class="clear"></div>
                    <div id="change_btn_row">
                        <?php echo form_hidden('base_url', base_url()) ?>
			<?php echo form_hidden(array('name' => 'user_email', 'id' => 'user_email', 'value' => $this->session->userdata('email'))) ?>
                        <?php echo form_button(array('class' => 'button', 'id' => 'change_btn', 'content' => 'Continue')) ?>
                    </div>
                    <div class="clear"></div>
                    <div id="change_status"></div>
                </fieldset>
            <?php echo form_close() ?>
        </div>

        </div> <!-- End #messages -->

    </div>
<?php endif ?>