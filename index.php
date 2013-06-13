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
            <?php
            include_once('libs/WmsDatabaseManager.php'); 
            include_once('entities/wmsEntity.php');
            include_once('libs/LayerDatabaseManager.php'); 
            include_once('entities/layerEntity.php'); 
            $wmsMan = new wmsDatabaseManager();
            $layerMan = new layerDatabaseManager();

            function PrintLevel($layerMan,$id, $wmsid, $level)
                {
                    foreach ($layerMan->GetUnderLayers($wmsid, $id) as $layer)
                    {
                        if(count($layerMan->GetUnderLayers($wmsid, $layer->id))==0)
                            print("<li><a href='layerDetails2.php?layerid=".$layer->id."'  data-ajax=\"false\"  >");
                        echo htmlspecialchars($layer->title, ENT_COMPAT, 'UTF-8');
                        print("</a></li>");

                    }
                    print("
                        </ul>
                     </div>");
                    foreach ($layerMan->GetUnderLayers($wmsid, $id) as $layer)
                    {
                        if(count($layerMan->GetUnderLayers($wmsid, $layer->id))!=0)
                        {
                            //print("<li data-role='list-divider'>");
                            print("<div data-role=\"collapsible\">
        <h2>");
                            for ($i = 0; $i <= $level; $i++) {
                                print("-->");
                            }
                            echo htmlspecialchars($layer->title, ENT_COMPAT, 'UTF-8');
                            print("</h2>
        <ul data-role=\"listview\">");
                            PrintLevel($layerMan, $layer->id, $wmsid, $level+1);
                        }
                    }
                };
                
            foreach ($wmsMan->GetAllWms() as $item)
            {
                
                print("<div data-role=\"panel\" data-position=\"right\" data-display=\"overlay\" id=\"mypanel".$layerMan->GetRootLayerId($item->id)."\">
                <!-- panel content goes here -->
<div data-role=\"collapsible-set\" data-theme=\"b\">
<div data-role=\"collapsible\">");
echo '<h2>'.htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8').'</h2>';
        print("<ul data-role=\"listview\">
                ");
                PrintLevel($layerMan, $layerMan->GetRootLayerId($item->id), $item->id, 0);
                print("
                </ul>
            </div></div>");
            }
            ?>
            
            <div data-theme="a" data-role="header">
                <a data-role="button" data-ajax="false" href="addWms.php" class="ui-btn-left">
                    Add WMS
                </a>
                <h3>
                    WMS in repository
                </h3>
            </div>
            <div data-role="content">
                <table data-role="table" id="wms-table" data-mode="reflow" class="ui-responsive table-stroke">
                    <thead>
                      <tr>
                        <th data-priority="1">Title</th>
                        <th data-priority="1">Abstract</th>
                        <th data-priority="5">Details</th>
                        <th data-priority="5">Layers</th>
                        
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?
                        
                        foreach ($wmsMan->GetAllWms() as $item)
                        {
                            print("<tr>");
                            echo '<th>'.htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8').'</th><td>'.htmlspecialchars($item->abstract, ENT_COMPAT, 'UTF-8').'</td>';
                            print("<td><a data-role='button' data-inline=\"true\" data-transition=\"pop\" data-rel=\"popup\" href='#popupBasic".$item->id."'>Details</a></td>");
                            print("<div data-role=\"popup\" id=\"popupBasic".$item->id."\">");
                            echo '<h2>'.htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8').'</h2>';
                            echo '<h3>'.htmlspecialchars($item->abstract, ENT_COMPAT, 'UTF-8').'</h3>';
                            echo '<h3>'.htmlspecialchars($item->name, ENT_COMPAT, 'UTF-8').'</h3>';
                            echo '<p>'.htmlspecialchars($item->wmsUrl, ENT_COMPAT, 'UTF-8').'</p>';
                            echo '<p>id:'.$item->id.'</p>';
                            echo '<p>version:'.htmlspecialchars($item->version, ENT_COMPAT, 'UTF-8').'</p>';
                            print("</div>");
                            print("<td><a data-role='button' href=\"#mypanel".$layerMan->GetRootLayerId($item->id)."\">Show layers</a></td>");
                            print("</tr>");
                        }
                    ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

