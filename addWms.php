
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="jquerymobile/jquery.mobile-1.3.0.min.css" />
        <script src="jquerymobile/jquery-1.8.2.min.js"></script>-->
        <script src="jquerymobile/jquery.mobile-1.3.0.min.js"></script>
        <!--LEAFLET-->
        <link rel="stylesheet" href="leaflet/leaflet.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="leaflet/leaflet.ie.css" /><![endif]-->
        <script src="leaflet/leaflet.js"></script>
    </head>
    <body>
        
        <div data-role="page" data-add-back-btn="true"  id="addWms">
            <div data-theme="a" data-role="header">
                <h3>
                    Add WMS
                </h3>
            </div>
            <div data-role="content">
                <form method="GET" action="addWms2.php" >
                <p>WMS adress: 
                    <input type="text" name="address" size="80"> 
                    <input type="submit" value="Add WMS">
                </p>
                </form>
                
            </div>
        </div>
        
    </body>
</html>
