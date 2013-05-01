<?php
include_once('GetCapabilitiesParser.php');

$adress = $_GET["adress"] ;

print("<p>inserted adress:".$adress."</p>");
$xml = simplexml_load_file($adress);
if(GetCapabilitiesParser::ParseAndAddToDB($xml, $adress)==0)
    GetCapabilitiesParser::ParseAndAddToDB($xml, $adress."?SERVICE=WMS&REQUEST=GetCapabilities");

print($adress." was added to repository");
?>
