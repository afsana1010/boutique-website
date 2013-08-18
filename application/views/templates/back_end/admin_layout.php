<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="<?php echo base_url() ?>" />

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <title><?php echo $title; ?></title>

        <link rel="stylesheet" href="assets/css/admin/reset.css" type="text/css" media="screen" />
        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="assets/css/admin/style.css" type="text/css" media="screen" />

        <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
        <link rel="stylesheet" href="assets/css/admin/invalid.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="assets/css/admin/jquery-ui-1.9.1.custom.css" />
        <?php $this->load->view('extra/styles/style_includes') ?>	

        <!-- Colour Schemes
    Default colour scheme is green. Uncomment prefered stylesheet to use it.
        <link rel="stylesheet" href="assets/css/admin/blue.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="assets/css/admin/red.css" type="text/css" media="screen" />  
        -->

        <!-- Internet Explorer Fixes Stylesheet -->
        <!--[if lte IE 7]>
                <link rel="stylesheet" href="assets/css/admin/ie.css" type="text/css" media="screen" />
        <![endif]-->

        <script type="text/javascript" src="assets/js/common/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="assets/js/common/jquery-ui-1.9.1.custom.js"></script>
        <script type="text/javascript" src="assets/js/admin/simpla.jquery.configuration.js"></script>
        <script type="text/javascript" src="assets/js/admin/facebox.js"></script>
        <script type="text/javascript" src="assets/js/admin/jquery.wysiwyg.js"></script>
        <script type='text/javascript' src='assets/js/admin/jquery.tablesorter.min.js'></script>
        

        <?php $this->load->view('extra/scripts/script_includes') ?>
        <script type="text/javascript" src="assets/js/admin/common.js"></script>
        
        
        <!-- Internet Explorer .png-fix -->
        <!--[if IE 6]>
                <script type="text/javascript" src="assets/js/admin/DD_belatedPNG_0.0.7a.js"></script>
                <script type="text/javascript">
                        DD_belatedPNG.fix('.png_bg, img, li');
                </script>
        <![endif]-->

    </head>

    <body>
        <?php echo form_open('', array('id' => 'layout_form')) ?>
        <?php echo form_hidden('base_url', base_url()) ?>
        <?php echo form_close() ?>
        
        
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

            <div id="sidebar">
                <?php $this->load->view('includes/back_end/sidebar') ?>
            </div> <!-- End #sidebar -->

            <div id="main-content"> <!-- Main Content Section with everything -->

                <noscript> <!-- Show a notification if the user has disabled javascript -->
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>

                <!-- Page Head -->
                <?php $this->load->view('includes/back_end/header') ?>
                <!-- End .shortcut-buttons-set -->

                <div class="clear"></div> <!-- End .clear -->

                <div class="content-box"><!-- Start Content Box -->
                    <?php echo $main_content ?>
                </div> <!-- End .content-box -->

                <div class="content-box column-left">
                    <?php $this->load->view('includes/back_end/content_left') ?>	
                </div> <!-- End .content-left-box -->

                <?php $this->load->view('includes/back_end/notifications') ?>
                
                <div class="content-box column-right closed-box">
                    <?php $this->load->view('includes/back_end/content_right') ?>
                </div> <!-- End .content-box -->
                <div class="clear"></div>

                <div id="footer">
                <?php $this->load->view('includes/back_end/footer') ?>
                </div><!-- End #footer -->

            </div> <!-- End #main-content -->

        </div>

    </body>
</html>
