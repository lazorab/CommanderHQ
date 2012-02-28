<?php
class WodModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function InsertWOD($_DETAILS)
	{
		$FIELDS = '';
		$VALUES = '';
		$i = 0;
		foreach($_DETAILS AS $key=>$val) 
		{
			if($i > 0)
			{
				$FIELDS .= ',';
				$VALUES .= ',';
			}
				$FIELDS .= $key;
				$VALUES .= '"'.$val.'"';
			$i++;
		}
		$SQL = 'INSERT INTO WOD('.$FIELDS.') VALUES('.$VALUES.')';
		mysql_query($SQL);	
	}
	
	function getWOD()
	{
		$SQL = 'SELECT ActivityName, ActivityType, Description, Repetitions, Duration, WODate FROM WOD WHERE WODate = DATE_FORMAT(NOW(), "%Y-%m-%d") LIMIT 1';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$WOD = new WODObject($Row);
		
		return $WOD;
	}	

}

class WODObject
{
	var $ActivityName;
	var $ActivityType;
	var $Description;
	var $Repetitions;
	var $Duration;
	var $WODate;

	function __construct($Row)
	{
		$this->ActivityName = $Row['ActivityName'];
		$this->ActivityType = $Row['ActivityType'];
		$this->Description = $Row['Description'];
		$this->Repetitions = $Row['Repetitions'];
		$this->Duration = $Row['Duration'];
		$this->WODate = $Row['WODate'];
	}
}
?>