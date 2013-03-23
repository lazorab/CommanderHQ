<?php
class RegistergymModel extends Model
{
	var $ReturnValue;
	var $Wall='';
	
	function __construct()
	{
	
	}

        function Register()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'Update MemberDetails
		SET GymId = "'.$_REQUEST['AffiliateId'].'"
                WHERE MemberId = "'.$_COOKIE['UID'].'"';  
            $db->setQuery($SQL);
            $db->Query();
            
            return 'Success';
        }
        
        function getMemberGym()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL='SELECT GymId FROM MemberDetails WHERE MemberId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            
            return $db->loadResult(); 
        }
        
        function getAffiliates() 
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT AffiliateId,
            GymName
            FROM Affiliates
            WHERE GymName <> ""
            ORDER BY GymName';
            $db->setQuery($SQL);
            
            return $db->loadObjectList();
    }
}      

?>