<?php
class Model
{
	function __construct()
	{
            session_start();	
	}
        
    	function getGymDetails()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT AffiliateId, GymName, City, Region, URL
		FROM Affiliates
                WHERE AffiliateId = "'.$_COOKIE['GID'].'"';
            $db->setQuery($SQL);

            return $db->loadObject();
	}
}
?>