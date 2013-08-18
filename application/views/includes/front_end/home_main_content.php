<?php
$current_controller = $this->router->fetch_class();
$current_method = $this->router->fetch_method();
if (($current_controller == 'home') && ($current_method == 'index'))
{
?>
<div class="row" style="padding-top:10px;">
	<div class="span12">
		<img alt="" src="assets/images/front/header.jpg" title="">
	</div>
</div>

<br/>
<div class="row">
	<div class="span12 well well-large" style="width:928px;">
		<strong>Welcome</strong>. This the world's leading boutique shop, which delivers a wide variety of categories for male, female and kids. Also look at the sales options which we offer from season to season.
	</div>
</div>

<br/>
	<div class="row" style="padding-top:10px;">
		<div class="span3" style="padding-top:1px;">
			<img alt="" src="assets/images/front/boots_bag_lipsticks.png" title=""><br />
			Hoop up into the store to look for ladies <strong>handbags</strong>, <strong>boots</strong>, <strong>lipstick</strong>, <strong>removal</strong>, etc.
		</div>
		<div class="span3" style="padding-left:42px;">
			<img alt="" src="assets/images/front/bride.png" title="" style="border-color:#333333;"><br />
			We have also a great variety of bridal costumes, like <strong>hat</strong>, <strong>gloves</strong>, <strong>long-dress</strong>, etc.
		</div>
		<div class="span3" style="padding-left:40px;">
			<img alt="" src="assets/images/front/shipment.png" title="" style="border-color:#333333;"><br />
			We do always like to inform you about the stages of your valuable shipment. Please fill-up the consignment number below and hit the <strong>Go</strong> button to get up-to-date information.
		</div>
	</div>

<br />

<div class="row">
	<div class="span10" style="background-color:#333; height:2px;"></div>
</div>
<?php 
} 
else 
	{
		echo $home_main_content;
	}
?>