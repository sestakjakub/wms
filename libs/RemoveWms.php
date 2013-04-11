
<?php
include_once('WmsDatabaseManager.php');
include_once('LayerDatabaseManager.php');

$id = $_GET["id"] ;
$wmsMan = new wmsDatabaseManager();
$wmsMan->RemoveWMS($id);
$layerMan = new layerDatabaseManager();
$layerMan->RemoveLayersOfWms($id);
echo("wms with id ".$id." was removed");
?>
