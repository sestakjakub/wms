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
        $mysqli = new mysqli($_ENV['OPENSHIFT_MYSQL_DB_HOST'], $_ENV['OPENSHIFT_MYSQL_DB_USERNAME'],$_ENV['OPENSHIFT_MYSQL_DB_PASSWORD'], "wms", $_ENV['OPENSHIFT_MYSQL_DB_PORT']);
        
        if ($mysqli->connect_errno) {
            printf("Connect failed: %s", $mysqli->connect_error);
            exit();
        }

        if ($mysqli->query("DROP TABLE layer") === TRUE) {
            printf("Table layer successfully dropped.");
        }
        
        if ($mysqli->query("DROP TABLE wms") === TRUE) {
            printf("Table wms successfully dropped.");
        }
        
        $mysqli->close();
        ?>
    </body>
</html>
