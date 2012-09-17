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
	
	function Log()
	{
        $SQL = 'SELECT recid, Attribute FROM Attributes';
        $Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            if(isset($_REQUEST[''.$Row['Attribute'].''])){
                $AttributeValue = $_REQUEST[''.$Row['Attribute'].''];
                $SQL = 'INSERT INTO WODLog(MemberId, ExerciseId, WODTypeId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['exercise'].'", "'.$_REQUEST['wodtype'].'", "'.$Row['recid'].'", "'.$AttributeValue.'")';
                mysql_query($SQL);	
            }
        }
	}
	
	function getWOD($type, $date)
	{
		$SQL = 'SELECT ActivityName, ActivityType, Description, Repetitions, Duration, WODate FROM WOD WHERE WODate = DATE_FORMAT("'.$date.'", "%Y-%m-%d") LIMIT 1';
		//$Result = mysql_query($SQL);	
		//$Row = mysql_fetch_assoc($Result);
		//$WOD = new WODObject($Row);
		
		return $SQL;
	}
	
	function getWODTypes()
	{
		$SQL = 'SELECT recid, WODType AS ActivityType FROM WODTypes';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$WODTypes = new WODObject($Row);
		
		return $WODTypes;
	}		
	
	function getMemberGym()
	{
		$MemberGym = array();
		$Query = 'SELECT RG.GymName, RG.Country, RG.Region, RG.URL
		FROM RegisteredGyms RG
		JOIN MemberDetails MD ON MD.GymId = RG.recid
		WHERE MD.MemberId = "'.$_SESSION['UID'].'"';
		$Result = mysql_query($Query);	
		if(mysql_num_rows($Result) > 0){
			$Row = mysql_fetch_assoc($Result);
			$MemberGym = new GymObject($Row);
		}
		else{
			$MemberGym = false;
		}
		return $MemberGym;
	}
}

class WODObject
{
	var $recid;
	var $ActivityName;
	var $ActivityType;
	var $Description;
	var $Attribute;
	var $AttributeValue;
	var $WODate;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
		$this->ActivityName = isset($Row['ActivityName']) ? $Row['ActivityName'] : "";
		$this->ActivityType = isset($Row['ActivityType']) ? $Row['ActivityType'] : "";
		$this->Description = isset($Row['Description']) ? $Row['Description'] : "";
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
		$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
		$this->WODate = isset($Row['WODate']) ? $Row['WODate'] : "";
	}
}

class GymObject
{
	var $recid;
	var $GymName;
	var $Country;
	var $Region;
	var $TelNo;
	var $Email;
	var $URL;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
		$this->GymName = isset($Row['GymName']) ? $Row['GymName'] : "";
		$this->Country = isset($Row['Country']) ? $Row['Country'] : "";
		$this->Region = isset($Row['Region']) ? $Row['Region'] : "";
		$this->TelNo = isset($Row['TelNo']) ? $Row['TelNo'] : "";
		$this->Email = isset($Row['Email']) ? $Row['Email'] : "";	
		$this->URL = isset($Row['URL']) ? $Row['URL'] : "";
	}
}
?>