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
        
        <div data-role="page" id="addWms2">
            <div data-theme="a" data-role="header">
                <!--<h3>-->
                <?php
                include_once('libs/GetCapabilitiesParser.php');
                include_once('libs/WmsDatabaseManager.php'); 
                include_once('entities/wmsEntity.php');
                include_once('libs/LayerDatabaseManager.php'); 
                include_once('entities/layerEntity.php'); 
                
                $address = $_GET["address"];
                $xml = simplexml_load_file($address);
                print("id:");
                echo GetCapabilitiesParser::ParseAndAddToDB($xml, $address);
                print("<p>".$address." was added to repository</p>");
                ?>
                <!--</h3>-->
            </div>
            <div data-role="content">
                <p> 
                    <a href="index.php" type="button">Go back to repository</a>
                </p>
                
            </div>
        </div>
        
    </body>
</html>
