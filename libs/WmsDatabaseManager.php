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
        $version = $wmsEntity->version;
        
        if ($this->mysqli->query("INSERT INTO wms VALUES (NULL, '$adress', '$name', '$title', '$abstract', '','$version')") === TRUE)
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
            $item->version = $row[6];
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
    
    public function GetWms($idWms)
    {
        $result = $this->mysqli->query("SELECT * FROM wms WHERE id = $idWms");
        $result2 = $result->fetch_row();
        $item = new wmsEntity();
        $item->id = $result2[0];
        $item->wmsUrl = $result2[1];
        $item->name = $result2[2];
        $item->title = $result2[3];
        $item->abstract = $result2[4];
        $item->version = $result2[6];
        return $item;
    }
    
   
}

?>
