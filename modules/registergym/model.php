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
            
            return 'Successfully Updated!';
        }
}      

?>