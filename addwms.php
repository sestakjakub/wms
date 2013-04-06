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
        include_once('GetCapabilitiesParser.php');
        
        $adress = $_GET["adress"] ;
        
        print("<p>inserted adress:".$adress."</p>");
        $xml = simplexml_load_file($adress);
        GetCapabilitiesParser::ParseAndAddToDB($xml, $adress);
        
        ?>
    </body>
</html>
