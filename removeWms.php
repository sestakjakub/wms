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
        include_once('managers/layerDatabaseManager.php');
        
        $id = $_GET["id"] ;
        
        $wmsMan = new wmsDatabaseManager();
        $wmsMan->RemoveWMS($id);
        $layerMan = new layerDatabaseManager();
        $layerMan->RemoveLayersOfWms($id);
        ?>
    </body>
</html>
