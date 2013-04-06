<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of layerDatabaseManager
 *
 * @author Jakub
 */
class layerDatabaseManager {
    
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
    }
    
    public function AddLayer(layerEntity $layer)
    {
        if ($this->mysqli->query("INSERT INTO layer VALUES (NULL, '$layer->WMSid', '$layer->upperLayerId', '$layer->name', '$layer->title', '$layer->abstract', '$layer->keywords','$layer->bBoxNorth','$layer->bBoxSouth','$layer->bBoxEast','$layer->bBoxWest')") === TRUE)
        {
            return $this->mysqli->insert_id;
        } else {
            return 0;
        }
    }
    
    //parameters
    //idWms-id of wms
    //idUpperLayer-id of upper layer, 0 for root
    //return array of layerEntity objects
    public function GetUnderLayers($idWms, $idUpperLayer)
    {
        $result = $this->mysqli->query("SELECT * FROM layer WHERE wmsId = $idWms AND upperLayerId = $idUpperLayer");
        if($result!=null)
        {
            $res = array();
            while ($row = $result->fetch_row()) 
            {
                $item = new layerEntity();
                $item->id = $row[0];
                $item->WMSid = $row[1];
                $item->upperLayerId = $row[2];
                $item->name = $row[3];
                $item->title = $row[4];
                $item->abstract = $row[5];
                $item->keywords = $row[6];
                $item->bBoxNorth = $row[7];
                $item->bBoxSouth = $row[8];
                $item->bBoxEast = $row[9];
                $item->bBoxWest = $row[10];
                array_push($res, $item);
            }
            $result->close();
            return $res;
        }
        
    }
    
    
//    return layerEntity
    
    public function GetLayer($idWms, $idLayer)
    {
        $result = $this->mysqli->query("SELECT * FROM layer WHERE wmsId = $idWms AND id = $idLayer");
        $result2 = $result->fetch_row();
        $item = new layerEntity();
        $item->id = $result2[0];
        $item->WMSid = $result2[1];
        $item->upperLayerId = $result2[2];
        $item->name = $result2[3];
        $item->title = $result2[4];
        $item->abstract = $result2[5];
        $item->keywords = $result2[6];
        $item->bBoxNorth = $result2[7];
        $item->bBoxSouth = $result2[8];
        $item->bBoxEast = $result2[9];
        $item->bBoxWest = $result2[10];
        return $result2;
    }
    
    public function RemoveLayersOfWms($wmsId)
    {
        if ($this->mysqli->query("DELETE FROM wms WHERE wmsId=$wmsId") === TRUE)
            return 0;
        return -1;
        
    }
    
}

?>
