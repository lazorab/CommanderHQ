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
            $Message = '';
            if(isset($_SESSION['UID'])){
                $SQL = 'SELECT FirstName FROM Members WHERE UserId = "'.$_SESSION['UID'].'"';
                $Result = mysql_query($SQL);	
                $Row = mysql_fetch_assoc($Result);
                $FirstName = $Row['FirstName'];

                $SQL = 'SELECT Message FROM RandomMessage WHERE recid = 1';
                $Result = mysql_query($SQL);	
                $Row = mysql_fetch_assoc($Result);
                $Message = str_replace('{NAME}',$FirstName,$Row['Message']);
            }
            else{
                $Message = 'Subscribe to get full use of Commander';
            }
		
            return $Message;	
	}
        
 	function getMessage()
	{
            $SQL = 'SELECT Message FROM ActionMessages WHERE recid = '.$_REQUEST['message'].'';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            $Message = $Row['Message'];
		
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