<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="leaflet/leaflet.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="leaflet/leaflet.ie.css" /><![endif]-->
    </head>
    <body>
        <?php
        $north = $_GET["north"];
        $south = $_GET["south"];
        $east = $_GET["east"];
        $west = $_GET["west"];
        $name = $_GET["name"];
        
        ?>
        
        
        <div id="map" style="width: 600px; height: 400px"></div>
	<script src="leaflet/leaflet.js"></script>
	<script>
		var map = L.map('map').setView([<?php echo ($south+$north)/2 ?>, <?php echo ($east+$west)/2 ?>], 6);
		L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
		}).addTo(map);
		L.polygon([
			[<?php echo $north ?>, <?php echo $west ?>],
			[<?php echo $north ?>, <?php echo $east ?>],
			[<?php echo $south ?>, <?php echo $east ?>],
			[<?php echo $south ?>, <?php echo $west ?>]
		]).addTo(map).bindPopup("<?php echo $name ?>");
	</script>
        
    </body>
</html>
