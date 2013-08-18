<?php

/**
 * This file includes external links of extra JavaScripts
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
*/
$current_controller = $this->router->fetch_class(); 
$current_method     = $this->router->fetch_method();

/* loads script to manage product-section */
if ($current_controller == 'product_section')
    echo "<script src='" . base_url() . "assets/js/admin/product_section.js' type='text/javascript'></script>";

/* loads script to manage category */
if ($current_controller == 'category')
    echo "<script src='" . base_url() . "assets/js/admin/category.js' type='text/javascript'></script>";

/* loads script to manage member */
if ($current_controller == 'member') 
    echo "<script src='" . base_url() . "assets/js/admin/member.js' type='text/javascript'></script>";

/* loads script to manage country_code */
if ($current_controller == 'country_code')
    echo "<script src='" . base_url() . "assets/js/admin/country_code.js' type='text/javascript'></script>";

/* loads script to manage product */
if ($current_controller == 'product')
{
    if ($current_method == 'manage') //loads plugins and configurations to upload image
    {
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/swfobject.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.uploadify.v2.1.4.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.jgrowl_minimized.js'></script>";
        $this->load->view('extra/scripts/product');
    }
    elseif ( ($current_method == 'shopping_cart') || ($current_method == 'display_shopping_cart') ) //loads script in the shopping-cart page
        echo "<script src='" . base_url() . "assets/js/front/shopping_cart.js' type='text/javascript'></script>";
    elseif ($current_method == 'display') //loads UI plugins in the front display-list
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/front/display_product.js'></script>";
    else //loads script in the listing page
        echo "<script src='" . base_url() . "assets/js/admin/product.js' type='text/javascript'></script>";
}//end if



/* loads script to manage advertisement-image */
if ($current_controller == 'advertisement')
{
    if ($current_method == 'manage') //loads plugins and configurations to upload image
    {
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/swfobject.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.uploadify.v2.1.4.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.jgrowl_minimized.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/advertisement.js'></script>";
        $this->load->view('extra/scripts/advertisement');
    }
    else //loads script in the listing page
        echo "<script src='" . base_url() . "assets/js/admin/advertisement.js' type='text/javascript'></script>";
}//end if/* loads script to manage advertisement-image *//


if ($current_controller == 'shipment')
{
    if ($current_method == 'manage') //loads plugins and configurations to upload image
    {
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/swfobject.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.uploadify.v2.1.4.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.jgrowl_minimized.js'></script>";
        //$this->load->view('extra/scripts/shipment');
    }
    else //loads script in the listing page
        echo "<script src='" . base_url() . "assets/js/admin/shipment.js' type='text/javascript'></script>";
}//end if


/* loads script to manage advertisement-image */
if ($current_controller == 'payment')
{
    if ($current_method == 'manage') //loads plugins and configurations to upload image
    {
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/swfobject.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.uploadify.v2.1.4.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/jquery.jgrowl_minimized.js'></script>";
        echo "<script type='text/javascript' src='" . base_url() . "assets/js/admin/payment.js'></script>";
    }
    else //loads script in the listing page
        echo "<script src='" . base_url() . "assets/js/admin/advertisement.js' type='text/javascript'></script>";
}//end if/* loads script to manage advertisement-image *//


?>
