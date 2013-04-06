<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        include_once('managers/wmsDatabaseManager.php'); 
        include_once('entities/wmsEntity.php');
        include_once('managers/layerDatabaseManager.php'); 
        include_once('entities/layerEntity.php'); 
        
        $wmsId = $_GET["id"] ;
        
        $layerMan = new layerDatabaseManager();
        
        function printAllLayers($upperLayer, $wmsId, $layerMan)
        {
        print("<ul>");
        foreach ($layerMan->GetUnderLayers($wmsId, $upperLayer) as $item)
        {
            print("<li>".$item->name." ".$item->title." ".$item->abstract." ");
            if(($item->bBoxNorth!=0)||($item->bBoxSouth!=0)||($item->bBoxEast!=0)||($item->bBoxWest!=0))
                print("<a href='https://wms-sestak.rhcloud.com/boxOnMap.php?north=$item->bBoxNorth&south=$item->bBoxSouth&east=$item->bBoxEast&west=$item->bBoxWest&name=$item->name'>BBox on map</a>");
            print("</li>");    
            printAllLayers($item->id, $wmsId, $layerMan);
        }
        print("</ul>");
        }
        
        printAllLayers(0, $wmsId, $layerMan);

        ?>
    </body>
</html>
