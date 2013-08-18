<div class="span3 pull-left">
	<img alt="" src="assets/images/front/logo.png" title="" style="border-color:#333333;">
	<br /><br />        
        <div class="btn-toolbar" style="margin: 0;">
                <?php $sections = $this->common_model->query_multiple_rows_by_single_source('boutique_product_sections', 'is_active', 1) ?>
                <?php foreach($sections as $s) : ?>
                    <div class="btn-group" style="text-align:left;">
                        <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><?php echo ucfirst($s->name) ?> <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <?php $category_list = $this->common_model->query_multiple_rows_by_single_source('boutique_categories', 'product_section_id', $s->id) ?>
                            <?php if(isset($category_list)) : ?>
                                <?php foreach($category_list as $row): ?>
                                    <li><a href="product/display/<?php echo $row->id ?>">
                                        <i class="icon-th-list"></i> <?php echo $row->name;?></a></li>
                                    </li>
                                <?php endforeach ?>
                            <?php endif ?>
                        </ul>
                    </div>
                <?php endforeach ?><!-- /btn-group -->
	</div><!-- /btn-toolbar -->
</div>
<div class="span3" style="padding-top:48px;">
	<form class="form-inline" style="">
		<input type="text" placeholder="search product">
		<button type="submit" class="btn btn-small">
			<i class="icon-search"></i>
		</button>
	</form>
</div>
<div class="span3 pull-right">
	<div class="btn-group" style="text-align:left;">
		<button class="btn dropdown-toggle" data-toggle="dropdown">
			<img alt="" src="assets/images/front/currencies/coins.png" title="">&nbsp;Currency <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="#"><img alt="" src="assets/images/front/currencies/sgd.png" width="24" title="">&nbsp;SGD</a></li>
			<li><a href="#"><img alt="" src="assets/images/front/currencies/usd.png" width="24" title="">&nbsp;USD</a></li>
			<li><a href="#"><img alt="" src="assets/images/front/currencies/euro.png" width="24" title="">&nbsp;GBP</a></li>
		</ul>
	</div>
	<br />
	<?php if($this->session->userdata('user_id') && $this->session->userdata('logged_in_as')=='user') : ?>
        Welcome <em><?php echo $this->session->userdata('name') ?></em> !!
        <?php endif ?>
	<br />
	<?php if($this->session->userdata('user_id') && $this->session->userdata('logged_in_as')=='user') : ?>
            <?php $number_of_cart_items = $this->common_model->num_of_data('boutique_shopping_cart', 'WHERE user_id = ' . $this->session->userdata('user_id')) ?>
            <?php if ($number_of_cart_items > 0) : ?>
                <?php $this->load->model('product_model') ?>
                <?php $total_items = $this->product_model->get_specific_shopping_cart_info($this->session->userdata('user_id'), 'total_quantities') ?>
                <?php $total_price = $this->product_model->get_specific_shopping_cart_info($this->session->userdata('user_id'), 'total_price') ?>
                <a href="product/display_shopping_cart">Shopping Cart: <strong><?php echo $total_items ?></strong> items worthing <strong><?php printf("%.2f", $total_price) ?> SGD</strong></a>
            <?php endif ?>
        <?php endif ?>
</div>