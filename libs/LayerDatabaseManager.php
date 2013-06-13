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
        
        if ($this->mysqli->connect_errno)
        {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        };
    }
    
    public function __destruct() {
        $this->mysqli->close();
    }
    
    public function AddLayer(layerEntity $layer)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO layer VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iissssddddii", $layer->WMSid, $layer->upperLayerId,
                $layer->name, $layer->title, $layer->abstract, $layer->keywords,
                $layer->bBoxNorth, $layer->bBoxSouth, $layer->bBoxEast, $layer->bBoxWest,
                $layer->minScale, $layer->maxScale);
        if ($stmt->execute()) {
            $stmt->close();
            return $this->mysqli->insert_id;
        }
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        return 0;    
        
    }
    
    //parameters
    //idWms-id of wms
    //idUpperLayer-id of upper layer, 0 for root
    //returns array of layerEntity objects
    //returns null on failiure
    public function GetUnderLayers($idWms, $idUpperLayer)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM layer WHERE wmsId = ? AND upperLayerId = ?");
        $stmt->bind_param("ii", $idWms, $idUpperLayer);
        if ($stmt->execute()) {
            $stmt->bind_result($row0,$row1,$row2,$row3,$row4,$row5,$row6,$row7,$row8,$row9,$row10,$row11,$row12);
            $res = array();
            while($stmt->fetch())
            {
                $item = new layerEntity();
                $item->id = $row0;
                $item->WMSid = $row1;
                $item->upperLayerId = $row2;
                $item->name = $row3;
                $item->title = $row4;
                $item->abstract = $row5;
                $item->keywords = $row6;
                $item->bBoxNorth = $row7;
                $item->bBoxSouth = $row8;
                $item->bBoxEast = $row9;
                $item->bBoxWest = $row10;
                $item->minScale = $row11;
                $item->maxScale = $row12;
                array_push($res, $item);
            }
            $stmt->close();
            return $res;
        }
        return null;
        
    }
    
    public function GetAllUpperLayers($idLayer)
    {
        $res=array();
        $layer=$this->GetLayer($idLayer);
        array_push($res,$layer);
        while(true)
        {
            if($layer->upperLayerId!=0)
            {
                $idLayer=$layer->upperLayerId;
                $layer=$this->GetLayer($idLayer);
                array_push($res,$layer);
            }
            else
                return $res;
        }
        return $res;
    }
    
    public function GetRootLayerId($idWms)
    {
        $stmt = $this->mysqli->prepare("SELECT id FROM layer WHERE wmsId = ? AND upperLayerId = 0");
        $stmt->bind_param("i", $idWms);
        if ($stmt->execute()) {
            $resId=0;
            $stmt->bind_result($resId);
            $stmt->fetch();
            $stmt->close();
            return $resId;
        }
        return null;
    }
    
//    returns layerEntity object on succ
//    returns null on failiure    
    public function GetLayer($idLayer)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM layer WHERE id = ?");
        
        $stmt->bind_param("i", $idLayer);
        if ($stmt->execute()) 
        {
            $stmt->bind_result($row0,$row1,$row2,$row3,$row4,$row5,$row6,$row7,$row8,$row9,$row10,$row11,$row12);
            $stmt->fetch();
            $item = new layerEntity();
            $item->id = $row0;
            $item->WMSid = $row1;
            $item->upperLayerId = $row2;
            $item->name = $row3;
            $item->title = $row4;
            $item->abstract = $row5;
            $item->keywords = $row6;
            $item->bBoxNorth = $row7;
            $item->bBoxSouth = $row8;
            $item->bBoxEast = $row9;
            $item->bBoxWest = $row10;
            $item->minScale = $row11;
            $item->maxScale = $row12;
            $stmt->close();
            return $item;
        }
        return null;
        
    }
    
    //returns 0 on succ, -1 on failiure
    public function RemoveLayersOfWms($wmsId)
    {
        $stmt = $this->mysqli->prepare("DELETE FROM wms WHERE wmsId=?");
        $stmt->bind_param("i", $wmsId);
        if ($stmt->execute()) {
            return 0;
        }
        return -1;
    }
    
}

?>
