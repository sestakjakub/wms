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
        <script>
            $(document).ready(function () {
                $('.remove').click(function() {
                    var wmsId = $(this).attr('wmsId');
                    var address = "libs/RemoveWms.php?id="+wmsId;
                    $.get(address,function(data,status){
                        alert("Data: " + data + "\nStatus: " + status);
                        window.location.reload(true);
                    });
                });
            });
            $(document).ready(function () {
                $('.reparse').click(function() {
                    var wmsId = $(this).attr('wmsId');
                    var address = "libs/ReparseWms.php?id="+wmsId;
                    $.get(address,function(data,status){
                        alert("Data: " + data + "\nStatus: " + status);
                        window.location.reload(true);
                    });
                });
            });
            
 
        </script>
    </head>
    <body>
        <div data-role="page" id="index">
            <div data-theme="a" data-role="header">
                <a data-role="button" href="addWms.php" class="ui-btn-left">
                    Add WMS
                </a>
                <h3>
                    WMS in repository
                </h3>
                <?php
                include_once('libs/WmsDatabaseManager.php'); 
                include_once('entities/wmsEntity.php');
                include_once('libs/LayerDatabaseManager.php'); 
                include_once('entities/layerEntity.php'); 
                ?>
            </div>
            <div data-role="content">
                <table data-role="table" id="wms-table" data-mode="reflow" class="ui-responsive table-stroke">
                    <thead>
                      <tr>
                        <th data-priority="1">Title</th>
                        <th data-priority="1">Abstract</th>
                        <th data-priority="5">Details</th>
                        <th data-priority="5">Layers</th>
                        <th data-priority="5">Remove</th>
                        <th data-priority="5">Reparse</th>
                        
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?
                        $wmsMan = new wmsDatabaseManager();
                        $layerMan = new layerDatabaseManager();

                        foreach ($wmsMan->GetAllWms() as $item)
                        {
                            print("<tr>");
                            print("<th>".$item->title."</th><td>".$item->abstract."</td>");
                            print("<td><a data-role='button' data-inline=\"true\" data-transition=\"pop\" data-rel=\"popup\" href='#popupBasic".$item->id."'>Details</a></td>");
                            print("<div data-role=\"popup\" id=\"popupBasic".$item->id."\">
                            <h2>".$item->title."</h2>
                            <h3>".$item->abstract."</h3>
                            <h3>".$item->name."</h3>
                            <p>".$item->wmsUrl."</p>
                            <p>id: ".$item->id."</p>
                            <p>version: ".$item->version."</p>
                            </div>");
                            print("<td><a data-role='button' data-transition=\"slide\" href=layerDetails.php?layerid=".$layerMan->GetRootLayerId($item->id).">Layers</a></td>");
                            print("<td><a data-role='button' class='remove' wmsId=$item->id>Remove</a></td>");
                            print("<td><a data-role='button' class='reparse' wmsId=$item->id>Reparse</a></td>");
                            print("</tr>");
                        }
                    ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
