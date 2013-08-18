<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	// Load the Visualization API and the piechart package.
	google.load('visualization', '1', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawChart);

	function drawChart() {
		var jsonData = $.ajax({
			url:'<?php echo base_url().'generate_downloadable_report/getSoldProductData'?>', //another controller function for generating data
			mtype : "post", //Ajax request type. It also could be GET
			dataType:"json",
			async: false
		}).responseText;

		// Create our data table out of JSON data loaded from server.
		var data = new google.visualization.DataTable(jsonData);
		
		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data, {width: 400, height: 240});
	}
</script>

<div class="content-box-header">
    <h3><?php echo $table_title ?></h3>
</div>

<div class="content-box-content">
    <div class="tab-content default-tab">
		Chart Test
		<!--Div that will hold the pie chart-->
		<div id="chart_div"></div>
	
    </div>        
</div>