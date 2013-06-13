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
        
        if ($this->mysqli->connect_errno)
        {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        };
    }
    
    public function __destruct() {
        $this->mysqli->close();
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
        $keywords = "";
        $version = $wmsEntity->version;
        
        $stmt = $this->mysqli->prepare("INSERT INTO wms VALUES (NULL, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("ssssss", $adress, $name, $title, $abstract, $keywords, $version);
        if ($stmt->execute()) {
            $stmt->close();
            return $this->mysqli->insert_id;
        }
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        return 0;    
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
    
    //returns 0 on success
    //returns -1 on failiure
    public function RemoveWMS($id)
    {
        $stmt = $this->mysqli->prepare("DELETE FROM wms WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return 0;
        }
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        return -1;
    }
    
    //returns null on failiure
    public function GetWms($idWms)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM wms WHERE id = ?");
        $stmt->bind_param("i", $idWms);
        if ($stmt->execute())
        {
            $result2=$stmt->fetch();
            $item = new wmsEntity();
            $item->id = $result2[0];
            $item->wmsUrl = $result2[1];
            $item->name = $result2[2];
            $item->title = $result2[3];
            $item->abstract = $result2[4];
            $item->version = $result2[6];
            $stmt->close();
            return $item;
        }
        $stmt->close();
        return null;
    }
}

?>
