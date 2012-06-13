<?php
class Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function getRandomMessage()
	{
		session_start();
		$Member = new Member($_SESSION['UID']);
		$MemberDetails = $Member->Details();
		$SQL = 'SELECT Message FROM RandomMessage WHERE recid = 1';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Message = str_replace('{NAME}',$MemberDetails->FirstName,$Row['Message']);
		
		return $Message;	
	}
}
?>