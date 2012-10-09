<?php

class LocatorModel extends Model {

    function __construct() {
        mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
    }
    
    function getAffiliate($Id) {
      
        $Query = 'SELECT AffiliateId,
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
        $Result = mysql_query($Query);
        $Row = mysql_fetch_assoc($Result);
        $Affiliate = new Affiliate($Row);
       
        return $Affiliate;
    }

    function getAffiliates() {
        $Affiliates = array();
         
        $StartLatitude = $_REQUEST['latitude'] - 1;
        $EndLatitude = $_REQUEST['latitude'] + 1;
        $StartLongitude = $_REQUEST['longitude'] - 1;
        $EndLongitude = $_REQUEST['longitude'] + 1;
        
        $Query = 'SELECT AffiliateId,
            GymName,
            URL,
            Address,
            City,
            Region,
            TelNo
            FROM Affiliates
            WHERE (Longitude BETWEEN "'.$StartLatitude.'" AND "'.$EndLatitude.'")
            AND (Latitude BETWEEN "'.$StartLongitude.'" AND "'.$EndLongitude.'")';
        $Result = mysql_query($Query);
        while($Row = mysql_fetch_assoc($Result)){
            array_push($Affiliates, new Affiliate($Row));
        } 
        return $Affiliates;
    }
    
    function getAffiliatesFromSearch() {
        $Affiliates = array();
        
        $Query = 'SELECT AffiliateId,
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
        $Result = mysql_query($Query);
        while($Row = mysql_fetch_assoc($Result)){
            array_push($Affiliates, new Affiliate($Row));
        } 
        return $Affiliates;
    }    

}

class Affiliate {

    var $AffiliateId;
    var $GymName;
    var $URL;
    var $Address;
    var $City;
    var $Region;
    var $TelNo;
    var $Latitude;
    var $Longitude;

    function __construct($Row) {
        $this->AffiliateId = isset($Row['AffiliateId']) ? $Row['AffiliateId'] : "";
        $this->GymName = isset($Row['GymName']) ? $Row['GymName'] : "";
        $this->URL = isset($Row['URL']) ? $Row['URL'] : "";
        $this->Address = isset($Row['Address']) ? $Row['Address'] : "";
        $this->City = isset($Row['City']) ? $Row['City'] : "";
        $this->TelNo = isset($Row['TelNo']) ? $Row['TelNo'] : "";
        $this->Region = isset($Row['Region']) ? $Row['Region'] : "";
        $this->Latitude = isset($Row['Latitude']) ? $Row['Latitude'] : "";
        $this->Longitude = isset($Row['Longitude']) ? $Row['Longitude'] : "";
    }
}

?>