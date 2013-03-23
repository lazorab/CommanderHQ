<?php
class Model
{
	function __construct()
	{
            session_start();
            mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
            @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
        
                function getSystemOfMeasure()
        {
            $SQL = 'SELECT SystemOfMeasure FROM MemberDetails WHERE MemberId = "'.$_COOKIE['UID'].'"';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            
            return $Row['SystemOfMeasure'];
        }
}
?>