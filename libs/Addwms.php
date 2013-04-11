<?php
include_once('GetCapabilitiesParser.php');

$adress = $_GET["adress"] ;

print("<p>inserted adress:".$adress."</p>");
$xml = simplexml_load_file($adress);
GetCapabilitiesParser::ParseAndAddToDB($xml, $adress);

print($adress." was added to repository");
?>
