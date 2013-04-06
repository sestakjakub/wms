<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>
    </head>
    <body>
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    WMS Repository
                </h3>
            </div>
            <div data-role="content">
                <form method="GET" action="addwms.php" >
                    <label for="text-1">WMS adress:</label>
                    <input type="text" name="adress" id="text-1" value="">
                    <input type="submit" value="Add WMS">
                </form> 
                <a href="allwms.php">Show all wms in repository</a>
            </div>
        </div>
        
        
        
        
        
        
 
    </body>
</html>
