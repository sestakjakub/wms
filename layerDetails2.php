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
                $wmsMan = new wmsDatabaseManager();
                $layer=$layerMan->GetLayer($layerId);
                $wms=$wmsMan->GetWms($layer->WMSid);
                
                $north=$layer->bBoxNorth;
                $south=$layer->bBoxSouth;
                $west=$layer->bBoxWest;
                $east=$layer->bBoxEast;
        ?>
        <div data-role="page" data-add-back-btn="true" id="layerDetails">
            <div data-theme="a" data-role="header">
                <h3>
                    <?php echo $layer->title ?>
                </h3>
            </div>
            <div data-role="content">
            <ul data-role='listview'>  
                <li data-role='list-divider'>Server Title: <?php echo $wms->title ?></li>
                
                <?php
                $array = array_reverse($layerMan->GetAllUpperLayers($layerId));
                foreach ($array as $lay)
                {
                    print("<li data-role='list-divider'>".$lay->title."</li>");
                    if ($lay->name!="")
                        print("<li><h3>Name: ".$lay->name."</h3></li>");
                    if ($lay->abstract!="")
                        print("<li><p>Abstract: ".$lay->abstract."</p></li>");
                    if ($lay->minScale!=0)
                        print("<li><p>Minimum scale denominator: ".$lay->minScale."</p></li>");
                    if ($lay->maxScale!=0)
                        print("<li><p>Maximum scale denominator: ".$lay->maxScale."</p></li>");
                    if(($lay->bBoxNorth!=0)||($lay->bBoxSouth!=0)||($lay->bBoxWest!=0)||($lay->bBoxEast!=0))
                    {
//                        print("<li>");
//                        print("<p>BBox North: ".$lay->bBoxNorth."</p>");
//                        print("<p>BBox South: ".$lay->bBoxSouth."</p>");
//                        print("<p>BBox West: ".$lay->bBoxWest."</p>");
//                        print("<p>BBox East: ".$lay->bBoxEast."</p>");
//                        print("</li>");
                        $north=$lay->bBoxNorth;
                        $south=$lay->bBoxSouth;
                        $west=$lay->bBoxWest;
                        $east=$lay->bBoxEast;
                    }
                        
                }
                $text= $wms->wmsUrl;
                list($url, $rest) = explode("?", $text, 2);
                print("<li>WMS adress: ".$url."<li>"); 
                ?>
                
                <li data-role='list-divider'>Bounding Box:</li>
                <li>
                <?php
                if(($north!=0)||($south!=0)||($east!=0)||($west!=0))
                {
                    $xcenter=($east+$west)/2;
                    $ycenter=($south+$north)/2;
                    print("
                    <div id = \"bmap\" style=\"min-height: 320px; height: 100%; margin: -15px;\"></div>
                    <script>

                    var bmap = L.map('bmap').setView([".$ycenter.", ".$xcenter."], 6);

                    L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
                            maxZoom: 18,
                            attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"http://cloudmade.com\">CloudMade</a>'
                    }).addTo(bmap);

                    var polygon = L.polygon([
                                [".$north.", ".$west."],
                                [".$north.", ".$east."],
                                [".$south.", ".$east."],
                                [".$south.", ".$west."]
                ]).addTo(bmap);

                    $(\"#layerDetails\").bind(\"pageshow\", function() {
                        setTimeout(function() {
                            bmap.invalidateSize();
                        }, 300);
                    });


                </script>
                ");
            }
            ?>
                </li>
                <?php
                
                   
//                    print("
//                    <div id = \"map\" style=\"min-height: 320px; height: 100%; margin: -15px;\"></div>
//                    <script>
//                    var map = L.map('map').setView([".$ycenter.", ".$xcenter."], 6);
//
//    
//                    L.tileLayer.wms(\"".$url."\", {
//                        layers: '".$layer->name."'
//                    }).addTo(map);
//
//
//                    $(\"#layerDetails\").bind(\"pageshow\", function() {
//                        setTimeout(function() {
//                            map.invalidateSize();
//                        }, 300);
//                    });
//
//
//                </script>
//                ");
            
            ?>
                </ul> 
                
            </div>
        </div>
    </body>
</html>
