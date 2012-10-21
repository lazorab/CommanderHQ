<?php

class LocatorModel extends Model {

    function __construct() {
        
    }
    
    function getAffiliate($Id) {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT AffiliateId,
            GymName,
            URL,
            Address,
            City,
            Region,
            TelNo,
            Longitude,
            Latitude
            FROM Affiliates
            WHERE AffiliateId = '.$Id.'';
        //echo $Query;
        $db->setQuery($SQL);
       
        return $db->loadObject();
    }

    function getAffiliates() {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE); 
        $StartLatitude = $_REQUEST['latitude'] - 1;
        $EndLatitude = $_REQUEST['latitude'] + 1;
        $StartLongitude = $_REQUEST['longitude'] - 1;
        $EndLongitude = $_REQUEST['longitude'] + 1;
        
        $SQL = 'SELECT AffiliateId,
            GymName,
            URL,
            Address,
            City,
            Region,
            TelNo
            FROM Affiliates
            WHERE (Longitude BETWEEN "'.$StartLatitude.'" AND "'.$EndLatitude.'")
            AND (Latitude BETWEEN "'.$StartLongitude.'" AND "'.$EndLongitude.'")';
        $db->setQuery($SQL); 
        
        return $db->loadObjectList();
    }
    
    function getAffiliatesFromSearch() {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT AffiliateId,
            GymName,
            URL,
            Address,
            City,
            Region,
            TelNo
            FROM Affiliates
            WHERE GymName LIKE "'.$_REQUEST['keyword'].'%"
            OR City LIKE "'.$_REQUEST['keyword'].'%"
            OR Region LIKE "'.$_REQUEST['keyword'].'%"';
        $db->setQuery($SQL); 
        
        return $db->loadObjectList();
    }    
}

?>