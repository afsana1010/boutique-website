<?php

/**
     * Author          : Mizanur Islam Laskar
     * About this file : This file includes external links of extra Style Sheets
*/

$current_controller = $this->router->fetch_class(); 
$current_method     = $this->router->fetch_method();

if (($current_controller == 'product') && ($current_method == 'manage')) 
{
    echo "<link rel='stylesheet' type='text/css' media='screen' href='" . base_url() . "assets/css/admin/uploadify.css'/>";
    echo "<link rel='stylesheet' type='text/css' media='screen' href='" . base_url() . "assets/css/admin/jquery.jgrowl.css'/>";
}

if (($current_controller == 'advertisement') && ($current_method == 'manage')) 
{
    echo "<link rel='stylesheet' type='text/css' media='screen' href='" . base_url() . "assets/css/admin/uploadify.css'/>";
    echo "<link rel='stylesheet' type='text/css' media='screen' href='" . base_url() . "assets/css/admin/jquery.jgrowl.css'/>";
}	
?>
