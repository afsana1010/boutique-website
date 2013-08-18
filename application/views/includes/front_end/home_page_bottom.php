<?php
$current_controller = $this->router->fetch_class();
$current_method = $this->router->fetch_method();
if (($current_controller == 'home') && ($current_method == 'index')):
?>

<div class="row">
	<div class="span4"></div>
	<div class="span2">About Boutique</div>
	<div class="span4"></div>
</div>

<div class="row" style="padding-top:2px;">
	<div class="span12">
		<small>
			The Boutique company was established in September, 2012. It offers to purchase a wide variety of categories, like <strong>Handbags</strong>, <strong>Boots</strong>, <strong>Man & Woman Cloths</strong>, etc.
		</small>
	</div>
</div>

<div class="row">
	<div class="span10" style="background-color:#333; height:2px;"></div>
</div>

<div class="row" align="center">
	<div class="span10" style="padding-top:17px; padding-left:0px;">
		<form action="shipment/shipment_tracking" class="form-inline" style="" method="post">
			Track your shipment
			<input type="text" name="tracking_number" class="input-large" placeholder="Enter consignment number">
			<button type="submit" class="btn btn-small">
				<i class="icon-search"></i> Go
			</button>
		</form>
	</div>
</div>
<?php endif;?>