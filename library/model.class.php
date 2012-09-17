<?php
class Model
{
	function __construct()
	{
            session_start();
            mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
            @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function getRandomMessage()
	{
            $Member = new Member($_SESSION['UID']);
            $MemberDetails = $Member->Details();
            $SQL = 'SELECT Message FROM RandomMessage WHERE recid = 1';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            $Message = str_replace('{NAME}',$MemberDetails->FirstName,$Row['Message']);
		
            return $Message;	
	}
        
        function getGender()
        {
            $SQL = 'SELECT Gender FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            
            return $Row['Gender'];
        }
        
        function getSystemOfMeasure()
        {
            $SQL = 'SELECT SystemOfMeasure FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            
            return $Row['SystemOfMeasure'];
        }
        
        function UserIsSubscribed()
        {
            $Status = false;
            if(SUBSCRIPTION){
                $SQL = 'SELECT Subscribed FROM MemberDetails WHERE MemberId = "'.$_SESSION['UID'].'"';
                $Result = mysql_query($SQL);	
                $Row = mysql_fetch_assoc($Result);
                $Status = $Row['Subscribed'];
            }else{
                $Status = true;
            }
            return $Status;
        }
}
?>