<!DOCTYPE html>
<html>

    <head>
        <base href="<?php echo base_url() ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>:: Boutique ::</title>
        <!-- <link rel="stylesheet" type="text/css" href="layout.css" /> -->
        <link rel="stylesheet" type="text/css" href="assets/css/front/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/front/extra.css" />
        
        <!-- Loads additional styles -->
        <?php $this->load->view('extra/styles/style_includes') ?>

        <!-- Optional: Include the jQuery library -->
        <script type="text/javascript" src="assets/js/common/jquery-1.8.2.min.js"></script>

        <!-- Optional: Incorporate the Bootstrap Javascript plugins -->
        <script src="assets/js/common/bootstrap.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function() 
                {
                    $('a.dropdown-toggle, .dropdown-menu a').on('touchstart', function(e) {
                        e.stopPropagation();
                    });
                });
        </script>
        
        <!-- Loads additional scripts -->
        <?php $this->load->view('extra/scripts/script_includes') ?>
    </head>

    <body>
        <div class="container" style="width:972px;">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <?php $this->load->view('includes/front_end/menu') ?>
            </div>

            <br /><br /><br />

            <div class="row" style="width:100%; padding-left:1px;">
                <?php $this->load->view('includes/front_end/header') ?>
            </div>

            <div class="row" style="width:100%; padding-top:10px; padding-left:1px;">
                <?php $this->load->view('includes/front_end/rotating_news') ?>
            </div>

            <div class="row" style="width:100%; padding-left:30px;">
                <?php $this->load->view('includes/front_end/notifications') ?>
            </div>

            <div class="row" style="width:100%; padding-left:30px;">
                <?php $this->load->view('includes/front_end/home_main_content') ?>
            </div>

            <div class="row" style="width:100%; padding-left:30px;">
                <?php $this->load->view('includes/front_end/home_page_bottom') ?>
            </div>

            <div id="footer" class="row">
                <?php $this->load->view('includes/front_end/footer') ?>
            </div>
        </div>
    </body>
</html>