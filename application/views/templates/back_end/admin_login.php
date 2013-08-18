<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="<?php echo base_url() ?>" />	
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title ?></title>

        <!-- Reset Stylesheet -->
        <link rel="stylesheet" href="assets/css/admin/reset.css" type="text/css" media="screen" />

        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="assets/css/admin/style.css" type="text/css" media="screen" />

        <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
        <link rel="stylesheet" href="assets/css/admin/invalid.css" type="text/css" media="screen" />	

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
        <script type="text/javascript" src="assets/js/admin/simpla.jquery.configuration.js"></script>
        <script type="text/javascript" src="assets/js/admin/facebox.js"></script>
        <script type="text/javascript" src="assets/js/admin/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="assets/js/admin/login.js"></script>

        <!-- Internet Explorer .png-fix -->
        <!--[if IE 6]>
                <script type="text/javascript" src="assets/js/admin/DD_belatedPNG_0.0.7a.js"></script>
                <script type="text/javascript">
                        DD_belatedPNG.fix('.png_bg, img, li');
                </script>
        <![endif]-->

    </head>

    <body id="login">

        <div id="login-wrapper" class="png_bg">
            <div id="login-top">
                <?php echo $login_top; ?>
            </div> <!-- End #logn-top -->

            <div id="login-content">
                <?php echo $login_panel; ?>	
            </div>

        </div>

    </body>

</html>