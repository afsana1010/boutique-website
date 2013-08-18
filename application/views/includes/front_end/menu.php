<div class="navbar-inner">
    <!--<a class="brand" href="#">Title</a>-->
    <ul class="nav">
        <li class="active"><a href="home">Home</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="category">Categories<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?php $sections = $this->common_model->query_multiple_rows_by_single_source('boutique_product_sections', 'is_active', 1) ?>
                <?php foreach($sections as $s) : ?>
                    <li class="dropdown-submenu">
                        <a href="#"><?php echo ucfirst($s->name) ?></a>
                        <ul class="dropdown-menu">
                            <?php $category_list = $this->common_model->query_multiple_rows_by_single_source('boutique_categories', 'product_section_id', $s->id) ?>
                            <?php foreach($category_list as $row) : ?>
                                <li>
                                    <a href="product/display/<?php echo $row->id ?>"><?php echo $row->name ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>
        </li>
        <?php if ($this->session->userdata('logged_in_as') != 'user') : ?>
        <li><a href="register">Register</a></li>
        <?php endif ?>
        <li><a href="site_information/about_us">About us</a></li>
        <li><a href="site_information/payment">Payment</a></li>
        <li><a href="site_information/delivery">Delivery</a></li>
        <li><a href="site_information/how_to_measure">Measuring</a></li>
        <li><a href="site_information/terms_and_condition">Terms</a></li>
        <li><a href="site_information/contact_us">Contact us</a></li>
        <li><a href="site_information/faq">FAQ</a></li>
        <?php if($this->session->userdata('user_id') && $this->session->userdata('logged_in_as')=='user') : ?>		
        <li><a href="member/member_profile_page">My Profile</a></li>
        <li><a href="member/member_page">My Orders</a></li>
        <li><a href="register/logout">Logout</a></li>
        <?php else : ?>
        <li><a href="register/login">Login</a>
        <?php endif ?>
    </ul>
</div>