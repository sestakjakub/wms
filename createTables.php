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

        if ($mysqli->query("CREATE TABLE IF NOT EXISTS `layer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `wmsId` bigint(20) NOT NULL,
  `upperLayerId` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `bBoxNorth` double DEFAULT NULL,
  `bBoxSouth` double DEFAULT NULL,
  `bBoxEast` double DEFAULT NULL,
  `bBoxWest` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2846 ;") === TRUE) {
            printf("Table layer successfully created.");
        }
        
        if ($mysqli->query("CREATE TABLE IF NOT EXISTS `wms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `wmsUrl` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;") === TRUE) {
            printf("Table wms successfully created.");
        }
        
        $mysqli->close();
        ?>
    </body>
</html>
