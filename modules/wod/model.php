<?php
class WodModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
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
        
        function getTopSelection()
        {
            $WodDetails = $this->getWODDetails($_REQUEST['topselection']);
            return $WodDetails;
        }
        
        function getMyGymFeed()
        {
            $WODDetails = array();
            $SQL = 'SELECT RG.GymName,
                RG.FeedURL
                FROM Members M
                LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId
                LEFT JOIN RegisteredGyms RG ON RG.recid = MD.GymId
		WHERE M.UserId = '.$_SESSION['UID'].'';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);          
            $URL = $Row['FeedURL'];
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $URL );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$XML = curl_exec ( $ch );
		curl_close ( $ch );

		$Doc = new DOMDocument;
		$Doc->loadXML ( $XML );
		$Doc->strictErrorChecking = FALSE;
			$TitleList = $Doc->getElementsByTagName ( "title" );
			foreach ( $TitleList as $CurrentNode ) {
                            $Row['WodDate'] = $CurrentNode->nodeValue;
                            array_push($WODDetails, new WODObject($Row));
			}  
                return $WODDetails;        
        }
        
        function getGymWodWorkouts()
        {
            $Workouts = array();
            $SQL = 'SELECT WW.recid AS WodId, WT.WorkoutType, WW.WodDate
                FROM WodWorkouts WW
                LEFT JOIN MemberDetails MD ON MD.GymId = WW.GymId
                LEFT JOIN WorkoutTypes WT ON WT.recid = WW.WodTypeId
                WHERE MD.MemberId = "'.$_SESSION['UID'].'"
                AND WodDate >= CURDATE()
                ORDER BY WorkoutName';
            $Result = mysql_query($SQL);	
            while($Row = mysql_fetch_assoc($Result))
            {
                $Row['WorkoutDescription'] = $this->WodDescription($Row['recid']);
                array_push($Workouts, new WODObject($Row));
            }
            return $Workouts;
        }       
        
         function getWODDetails($Id)
	{   
            $WODDetails = array();
            $SQL = 'SELECT WT.WodType, WW.WorkoutRoutineTypeId
                    FROM WODTypes WT 
                    LEFT JOIN WodWorkouts WW ON WW.WodTypeId = WT.recid
                    WHERE WW.recid = '.$Id.'';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);
            if($Row['WodType'] == 'Benchmarks'){
                
 		$SQL = 'SELECT BW.recid,
                        BW.WorkoutName, 
                        E.Exercise, 
                        E.recid AS ExerciseId, 
                        E.Acronym, 
                        "'.$this->BenchmarkDescription($Row['WorkoutRoutineTypeId']).'" AS WorkoutDescription,
                        A.Attribute, 
                        BD.AttributeValueMale, 
                        BD.AttributeValueFemale, 
                        RoundNo,
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Row['WorkoutRoutineTypeId'].'") AS TotalRounds
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
			WHERE BD.BenchmarkId = '.$Row['WorkoutRoutineTypeId'].'
			ORDER BY RoundNo, OrderBy, Attribute';               
            }else{
                
            
		$SQL = 'SELECT WW.WorkoutName, 
                        E.Exercise, 
                        E.Acronym, 
                        "'.$this->WodDescription($Id).'" AS WorkoutDescription,
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                        WD.AttributeValue,  
                        RoundNo
			FROM WodDetails WD
			LEFT JOIN WodWorkouts WW ON WW.recid = WD.WodId
			LEFT JOIN Exercises E ON E.recid = WD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = WD.AttributeId
			WHERE WD.WodId = '.$Id.'
			ORDER BY RoundNo, Attribute';
            }
		$Result = mysql_query($SQL);	
            while($Row = mysql_fetch_assoc($Result))
            {
                array_push($WODDetails, new WODObject($Row));  
            }
            return $WODDetails;
	}      
        
         function BenchmarkDescription($Id)
        {
            if($this->getGender() == 'M'){
                $AttributeValue = 'AttributeValueMale';
            } else {
                $AttributeValue = 'AttributeValueFemale';
            }
             $SQL = 'SELECT E.Exercise, 
                 E.Acronym, 
                 A.Attribute, 
                 '.$AttributeValue.' AS AttributeValue, 
                     WT.WorkoutType,
                     (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Id.'") AS TotalRounds,
                     BD.RoundNo
                FROM BenchmarkDetails BD
                LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
                LEFT JOIN WorkoutRoutineTypes WT ON WT.recid = BW.WorkoutTypeId
                WHERE BD.BenchmarkId = "'.$Id.'"
                GROUP BY Exercise
                ORDER BY OrderBy'; 
             return $this->MakeDescription($SQL);
        }       
        
         function WodDescription($Id)
        {
             $SQL = 'SELECT E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                WD.AttributeValue, 
                WT.WorkoutType
                FROM WodDetails WD
                LEFT JOIN Exercises E ON E.recid = WD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = WD.AttributeId
                LEFT JOIN WodWorkouts WW ON WW.recid = WD.WodId
                LEFT JOIN WorkoutRoutineTypes WT ON WT.recid = WW.WorkoutRoutineTypeId
                WHERE WD.WodId = "'.$Id.'"
                ORDER BY Exercise';            
            return $this->MakeDescription($SQL);
        }
        
        function MakeDescription($SQL)
        {
            $Result = mysql_query($SQL);
            $Exercise = '';
            $TotalRounds = '';
            $WorkoutType = '';
            while($Row = mysql_fetch_assoc($Result))
            {
                if($Exercise != $Row['Exercise']){
                    if($Description == ''){
                        if($Row['TotalRounds'] > 1){
                            $TotalRounds = ''.$Row['TotalRounds'].' Rounds | ';
                        }
                        if($Row['WorkoutType'] == 'Timed')
                            $WorkoutType = 'For Time | ';  
                        else
                            $WorkoutType = ''.$Row['WorkoutType'].' | ';
                    }
                    if($Row['Exercise'] != 'Timed' && $Row['Attribute'] != 'Reps')
                        $Description .= ''.$Row['Exercise'].' | ';
                    $Exercise = $Row['Exercise'];
                }
                if($Row['Attribute'] == 'Reps'){
                    //$Description .= ' ';
                    //$Description .= $Row['AttributeValue'];
                    //$Description .= ' ';
                    $Description .= ''.$Row['AttributeValue'].' '.$Row['Exercise'].' | ';
                }else if($Row['Attribute'] == 'Weight'){
                    //$Description .= ' ';
                   // $Description .= $Row['AttributeValue'];
                    //if($this->getSystemOfMeasure() == 'Metric')
                    //    $Description .= 'kg';
                    //else if($this->getSystemOfMeasure() == 'Imperial')
                    //    $Description .= 'lbs';
                }else if($Row['Attribute'] == 'Height'){
                    
                }else if($Row['Attribute'] == 'Distance'){
                    
                }else if($Row['Attribute'] == 'TimeToComplete'){
                    
                }else if($Row['Attribute'] == 'CountDown'){
                    
                }else if($Row['Attribute'] == 'Rounds'){
                    
                }else if($Row['Attribute'] == 'Calories'){
                    
                }
            }
            //$Description .= $TotalRounds.$WorkoutType;
            return $TotalRounds.$WorkoutType.$Description;           
        }       
        
        function getFeedDetails()
        {
            $WODDetails = array();
            $SQL = 'SELECT RG.GymName,
                RG.FeedURL
                FROM Members M
                LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId
                LEFT JOIN RegisteredGyms RG ON RG.recid = MD.GymId
		WHERE M.UserId = '.$_SESSION['UID'].'';
            $Result = mysql_query($SQL);	
            $Row = mysql_fetch_assoc($Result);          
            $URL = $Row['FeedURL'];
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $URL );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$XML = curl_exec ( $ch );
		curl_close ( $ch );

		$Doc = new DOMDocument;
		$Doc->loadXML ( $XML );
		$Doc->strictErrorChecking = FALSE;
                $i=1;		
		$ItemList = $Doc->getElementsByTagName("item");
                foreach ( $ItemList as $Item) {			
                    foreach ( $Item->childNodes as $nodename) {
                        if($nodename->nodeName == 'title' && urlencode($nodename->nodeValue) == $_REQUEST['Workout']){
                            $Description = $Doc->getElementsByTagName('description')->item($i);
                            $Row['WorkoutDescription'] = $Description->nodeValue;
                            $WODDetails = new WODObject($Row);                           
                        }
                    } 
		$i++;		
                }               
                return $WODDetails;        
        }        
        
         function getWodDescription($Id)
        {
            $Description = '';
            $SQL = 'SELECT E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                WD.AttributeValue, 
                WT.WorkoutType
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
		$Query = 'SELECT RG.AffiliateId, RG.GymName, RG.City, RG.Region, RG.URL
		FROM Affiliates RG
		JOIN MemberDetails MD ON MD.GymId = RG.AffiliateId
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
	var $WodId;
	var $WorkoutName;
	var $WodType;
	var $WorkoutDescription;
        var $Exercise;
        var $InputFieldName;  
        var $ExerciseId;
        var $RoundNo;
	var $Attribute;
	var $AttributeValue;
        var $AttributeValueMale;
        var $AttributeValueFemale;
	var $WodDate;
        var $TotalRounds;

	function __construct($Row)
	{
		$this->WodId = isset($Row['WodId']) ? $Row['WodId'] : "";
		$this->WorkoutName = isset($Row['WorkoutName']) ? $Row['WorkoutName'] : "";
		$this->WodType = isset($Row['WorkoutType']) ? $Row['WorkoutType'] : "";
		$this->WorkoutDescription = isset($Row['WorkoutDescription']) ? $Row['WorkoutDescription'] : "";
                $this->ExerciseId = isset($Row['ExerciseId']) ? $Row['ExerciseId'] : "";
                $this->RoundNo = isset($Row['RoundNo']) ? $Row['RoundNo'] : "";
                $this->Exercise = isset($Row['Exercise']) ? $Row['Exercise'] : "";
                if(isset($Row['Acronym']) && $Row['Acronym'] != '')
                    $this->InputFieldName = $Row['Acronym'];
                else
                    $this->InputFieldName = $this->Exercise;
		$this->Attribute = isset($Row['Attribute']) ? $Row['Attribute'] : "";
		$this->AttributeValue = isset($Row['AttributeValue']) ? $Row['AttributeValue'] : "";
                $this->AttributeValueMale = isset($Row['AttributeValueMale']) ? $Row['AttributeValueMale'] : "";
                $this->AttributeValueFemale = isset($Row['AttributeValueFemale']) ? $Row['AttributeValueFemale'] : "";
		$this->WodDate = isset($Row['WodDate']) ? $Row['WodDate'] : "";
                $this->TotalRounds = isset($Row['TotalRounds']) ? $Row['TotalRounds'] : "";
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
	var $FeedURL;
        var $WebURL;

	function __construct($Row)
	{
		$this->recid = isset($Row['recid']) ? $Row['recid'] : "";
		$this->GymName = isset($Row['GymName']) ? $Row['GymName'] : "";
		$this->Country = isset($Row['Country']) ? $Row['Country'] : "";
		$this->Region = isset($Row['Region']) ? $Row['Region'] : "";
		$this->TelNo = isset($Row['TelNo']) ? $Row['TelNo'] : "";
		$this->Email = isset($Row['Email']) ? $Row['Email'] : "";	
		$this->FeedURL = isset($Row['FeedURL']) ? $Row['FeedURL'] : "";
                $this->WebURL = isset($Row['WebURL']) ? $Row['WebURL'] : "";
	}
}
?>