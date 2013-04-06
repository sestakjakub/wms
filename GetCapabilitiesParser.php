<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetCapabilitiesParser
 *
 * @author Jakub
 */
class GetCapabilitiesParser {
    //put your code here
    public static function ParseAndAddToDB($xml,$adress)
    {
        include_once('managers/wmsDatabaseManager.php'); 
        include_once('entities/wmsEntity.php');
        include_once('managers/layerDatabaseManager.php'); 
        include_once('entities/layerEntity.php'); 
        
        $wms = new wmsEntity();
        $wms->name = $xml->Service->Name;
        $wms->title = $xml->Service->Title;
        $wms->abstract = $xml->Service->Abstract;
        $wms->wmsUrl = $adress;
                
        $dataMan = new wmsDatabaseManager();
        $wmsId = $dataMan->AddWms($wms);
        GetCapabilitiesParser::ParseLayer($xml->Capability, null, $wmsId);

    }
    
    private static function ParseLayer($xmlUpperLayer, $upperLayerId, $wmsId)
    {
        $layerMan = new layerDatabaseManager();
            foreach ($xmlUpperLayer->Layer as $xmllayer)
            {
                $layer = new layerEntity();
                $layer->WMSid = $wmsId;
                $layer->upperLayerId = $upperLayerId;
                $layer->name = $xmllayer->Name;
                $layer->title = $xmllayer->Title;
                $layer->abstract = $xmllayer->Abstract;
                
                $west = "";
                if($xmllayer->EX_GeographicBoundingBox->westBoundLongitude != "")
                    $west = $xmllayer->EX_GeographicBoundingBox->westBoundLongitude;
                if($xmllayer->LatLonBoundingBox['minx'] != "")
                    $west = $xmllayer->LatLonBoundingBox['minx'];
                $layer->bBoxWest = $west;
                
                
                $east = "";
                if($xmllayer->EX_GeographicBoundingBox->eastBoundLongitude != "")
                    $east = $xmllayer->EX_GeographicBoundingBox->eastBoundLongitude;
                if($xmllayer->LatLonBoundingBox['maxx'] != "")
                    $east = $xmllayer->LatLonBoundingBox['maxx'];
                $layer->bBoxEast=$east;
                
                $north = "";
                if($xmllayer->EX_GeographicBoundingBox->northBoundLatitude != "")
                    $north = $xmllayer->EX_GeographicBoundingBox->northBoundLatitude;
                if($xmllayer->LatLonBoundingBox['miny'] != "")
                    $north = $xmllayer->LatLonBoundingBox['miny'];
                $layer->bBoxNorth=$north;
                
                $south = "";
                if($xmllayer->EX_GeographicBoundingBox->southBoundLatitude != "")
                    $south = $xmllayer->EX_GeographicBoundingBox->southBoundLatitude;
                if($xmllayer->LatLonBoundingBox['maxy'] != "")
                    $south = $xmllayer->LatLonBoundingBox['maxy'];
                $layer->bBoxSouth=$south;
                
                $layerId = $layerMan->AddLayer($layer);
                GetCapabilitiesParser::ParseLayer($xmllayer, $layerId, $wmsId);
            }
    }
}

?>
