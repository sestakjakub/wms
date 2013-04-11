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
                
        ?>
        <div data-role="page" data-add-back-btn="true" id="layerDetails2">
            <div data-theme="a" data-role="header">
                <h3>
                    <?php echo $layer->title ?>
                </h3>
            </div>
            <div data-role="content">
                
                <?
               print("<a href='layerDetails.php?layerid=".$layerId."'  type=\"button\" data-transition=\"slide\"  >continue</a>");
            ?>
            </ul>    
            </div>
        </div>
    </body>
</html>
