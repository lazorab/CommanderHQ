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
	
        function getMyGymWOD()
	{   
            $WODDetails = array();
            $MyGym = $this->getMemberGym();
		$SQL = 'SELECT WW.recid,
                        WW.WorkoutName, 
                        E.Exercise, 
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                        WD.AttributeValue,  
                        WD.RoundNo
			FROM WodDetails WD
			LEFT JOIN WodWorkouts WW ON WW.recid = WD.WodId
			LEFT JOIN Exercises E ON E.recid = WD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = WD.AttributeId
			WHERE WW.GymId = '.$MyGym->recid.'
                        AND WW.WodDate = CURDATE()
			ORDER BY RoundNo, Attribute';
		$Result = mysql_query($SQL);	
            while($Row = mysql_fetch_assoc($Result))
            {
                $Row['WorkoutDescription'] = $this->getWodDescription($Row['recid']);
		array_push($WODDetails, new WODObject($Row));  
            }
            return $WODDetails;
	}
        
         function getWodDescription($Id)
        {
            $Description = '';
            $SQL = 'SELECT E.Exercise, A.Attribute, WD.AttributeValue, WT.WorkoutType
                FROM WodDetails WD
                LEFT JOIN Exercises E ON E.recid = WD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = WD.AttributeId
                LEFT JOIN WodWorkouts WW ON WW.recid = WD.WodId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WW.WorkoutTypeId
                WHERE WD.WodId = "'.$Id.'"
                ORDER BY Exercise';
            $Result = mysql_query($SQL);
            $Exercise = '';
            while($Row = mysql_fetch_assoc($Result))
            {
                if($Exercise != $Row['Exercise']){
                    if($Description == '')
                        $WorkoutType = $Row['WorkoutType'];
                    else
                        $Description .= ' | ';
                    if($Row['Exercise'] != 'Timed')
                        $Description .= $Row['Exercise'];
                    $Exercise = $Row['Exercise'];
                }
                if($Row['Attribute'] == 'Reps'){
                    $Description .= ' ';
                    $Description .= $Row['AttributeValue'];
                    $Description .= ' ';
                    $Description .= $Row['Attribute'];
                }else if($Row['Attribute'] == 'Weight'){
                    $Description .= ' ';
                    $Description .= $Row['AttributeValue'];
                    if($this->getSystemOfMeasure() == 'Metric')
                        $Description .= 'kg';
                    else if($this->getSystemOfMeasure() == 'Imperial')
                        $Description .= 'lbs';
                }else if($Row['Attribute'] == 'Height'){
                    
                }else if($Row['Attribute'] == 'Distance'){
                    
                }else if($Row['Attribute'] == 'TimeToComplete'){
                    
                }else if($Row['Attribute'] == 'CountDown'){
                    
                }else if($Row['Attribute'] == 'Rounds'){
                    
                }else if($Row['Attribute'] == 'Calories'){
                    
                }
            }
            $Description .= $WorkoutType;
            return $Description;           
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
		$Query = 'SELECT RG.recid, RG.GymName, RG.Country, RG.Region, RG.URL
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
	var $WorkoutName;
	var $WodType;
	var $WorkoutDescription;
	var $Attribute;
	var $AttributeValue;
	var $WodDate;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
		$this->WorkoutName = isset($Row['WorkoutName']) ? $Row['WorkoutName'] : "";
		$this->WodType = isset($Row['WorkoutType']) ? $Row['WorkoutType'] : "";
		$this->WorkoutDescription = isset($Row['WorkoutDescription']) ? $Row['WorkoutDescription'] : "";
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
		$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
		$this->WodDate = isset($Row['WodDate']) ? $Row['WodDate'] : "";
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