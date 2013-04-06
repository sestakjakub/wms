<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wmsDatabaseManager
 *
 * @author Jakub
 */
class wmsDatabaseManager {
    //put your code here
    protected $mysqli;
    
    public function __construct() {
        $this->mysqli = new mysqli($_ENV['OPENSHIFT_MYSQL_DB_HOST'], $_ENV['OPENSHIFT_MYSQL_DB_USERNAME'],$_ENV['OPENSHIFT_MYSQL_DB_PASSWORD'], "wms", $_ENV['OPENSHIFT_MYSQL_DB_PORT']);
        
        /* check connection */
        if ($this->mysqli->connect_errno)
        {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }
        ;
    }
    
    public function __destruct() {
        $this->mysqli->close();
        ;
    }
    
    //return
    //  id on succ
    //  0 on failiure
    public function AddWms(wmsEntity $wmsEntity)
    {
        $adress = $wmsEntity->wmsUrl;
        $name = $wmsEntity->name;
        $title = $wmsEntity->title;
        $abstract = $wmsEntity->abstract;
        
        if ($this->mysqli->query("INSERT INTO wms VALUES (NULL, '$adress', '$name', '$title', '$abstract', '')") === TRUE)
        {
            return $this->mysqli->insert_id;
        } else {
            return 0;
        }
    }    
    
    public function GetAllWms()
    {
        $result = $this->mysqli->query("SELECT * FROM wms");
        $res = array();
        while ($row = $result->fetch_row()) 
        {
            $item = new wmsEntity();
            $item->id = $row[0];
            $item->wmsUrl = $row[1];
            $item->name = $row[2];
            $item->title = $row[3];
            $item->abstract = $row[4];
            array_push($res, $item);

        }
        $result->close();
        return $res;
    }
    
    public function RemoveWMS($id)
    {
        if ($this->mysqli->query("DELETE FROM wms WHERE id=$id ") === TRUE)
            return 0;
        return -1;
        
    }
    
   
}

?>
