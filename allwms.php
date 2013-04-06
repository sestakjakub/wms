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
        <h1>WMS in repository:</h1>
        <table border="1">
        <?
        include_once('managers/wmsDatabaseManager.php'); 
        include_once('entities/wmsEntity.php');
        include_once('managers/layerDatabaseManager.php'); 
        include_once('entities/layerEntity.php'); 
        
        $wmsMan = new wmsDatabaseManager();
        
        print("<tr><th>id</th><th>Url</th><th>Name</th><th>Title</th><th>Abstract</th><th>Details</th></tr>");
        foreach ($wmsMan->GetAllWms() as $item)
        {
            print("<tr>");
            print("<td>".$item->id."</td><td>".$item->wmsUrl."</td><td>". $item->name."</td><td>".$item->title."</td><td>".$item->abstract."</td>");
            print("<td><a href=wmsDetails.php?id=".$item->id.">Layers</a></td>");
            print("<td><a href=removeWms.php?id=".$item->id.">Remove</a></td>");
            
            print("</tr>");
        }
        ?>
        </table>
    </body>
</html>
