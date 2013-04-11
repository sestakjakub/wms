<?php
include_once('GetCapabilitiesParser.php');
include_once('WmsDatabaseManager.php'); 
include_once('../entities/wmsEntity.php');
include_once('LayerDatabaseManager.php'); 
include_once('../entities/layerEntity.php');

$id = $_GET["id"] ;

$wmsMan = new wmsDatabaseManager();
$address = $wmsMan->GetWms($id)->wmsUrl;

$wmsMan->RemoveWMS($id);
$layerMan = new layerDatabaseManager();
$layerMan->RemoveLayersOfWms($id);
echo("wms with id ".$id." was removed");

$xml = simplexml_load_file($address);
print("id:");
echo GetCapabilitiesParser::ParseAndAddToDB($xml, $address);
print($address." was added to repository");

?>
