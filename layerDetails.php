<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="jquerymobile/jquery.mobile-1.3.0.min.css" />
        <script src="jquerymobile/jquery-1.8.2.min.js"></script>-->
        <script src="jquerymobile/jquery.mobile-1.3.0.min.js"></script>
        
        <!--LEAFLET-->
        <link rel="stylesheet" href="leaflet/leaflet.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="leaflet/leaflet.ie.css" /><![endif]-->
        <script src="leaflet/leaflet.js"></script>
       
    </head>
    <body>
        <?php
                include_once('libs/WmsDatabaseManager.php'); 
                include_once('entities/wmsEntity.php');
                include_once('libs/LayerDatabaseManager.php'); 
                include_once('entities/layerEntity.php'); 

                $layerId = $_GET["layerid"];

                $layerMan = new layerDatabaseManager();
                $layer=$layerMan->GetLayer($layerId);
                
                $north=$layer->bBoxNorth;
                $south=$layer->bBoxSouth;
                $west=$layer->bBoxWest;
                $east=$layer->bBoxEast;
                $name=$layer->name;
        ?>
        <div data-role="page" data-add-back-btn="true" id="layerDetails">
            <div data-theme="a" data-role="header">
                <h3>
                    <?php echo $layer->title ?>
                </h3>
            </div>
            <div data-role="content">
                <h2>Title: <?php echo $layer->title ?></h2>
                <p><strong>Name: <?php echo $layer->name ?></strong></p>
                <p>Abstract: <?php echo $layer->abstract ?></p>
                <p>Minimum scale denominator: <?php echo $layer->minScale ?></p>
                <p>Maximum scale denominator: <?php echo $layer->maxScale ?></p>
                
                
                <?php
                if(($north!=0)||($south!=0)||($east!=0)||($west!=0))
                {
                    $xcenter=($east+$west)/2;
                    $ycenter=($south+$north)/2;
                    print("
                    <div id = \"map\" style=\"min-height: 160px; height: 100%; margin: -15px;\"></div>
                    <script>

                    var map = L.map('map').setView([".$ycenter.", ".$xcenter."], 6);

                    L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
                            maxZoom: 18,
                            attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"http://cloudmade.com\">CloudMade</a>'
                    }).addTo(map);

                    var polygon = L.polygon([
                                [".$north.", ".$west."],
                                [".$north.", ".$east."],
                                [".$south.", ".$east."],
                                [".$south.", ".$west."]
                ]).addTo(map);

                    $(\"#layerDetails\").bind(\"pageshow\", function() {
                        setTimeout(function() {
                            map.invalidateSize();
                        }, 300);
                    });


                </script>
                ");
            }
            ?>
                
            <ul data-role='listview'>  
                <li data-role='list-divider'>Underlayers:</li>
            <?php
                foreach ($layerMan->GetUnderLayers($layer->WMSid, $layerId) as $item)
                    print("<li><a href='layerDetails2.php?layerid=".$item->id."' data-transition=\"slide\"  >".$item->title."</a></li>");
            ?>
            </ul>    
            </div>
        </div>
    </body>
</html>
