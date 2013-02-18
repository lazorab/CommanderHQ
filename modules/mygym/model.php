<?php
class MygymModel extends Model
{ 
	function __construct()
	{
	
	}
	
    function Log()
	{
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            if($this->UserIsSubscribed()){
                if($_REQUEST['TimeToComplete'] == "00:00:0"){
                    $this->Message .= "Invalid value for Stopwatch\nOr\nStopwatch not Started!";
                }else{
                    $ActivityFields = $this->getActivityFields();
                }
            //var_dump($ActivityFields);
            if($this->Message == ''){
                $WorkoutTypeId = $this->getWorkoutTypeId('My Gym');
                $TimeAttributeId = $this->getAttributeId('TimeToComplete');
                //Save the time
            $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue) 
            VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['WorkoutId'].'", "'.$WorkoutTypeId.'", "0", "0", "'.$TimeAttributeId.'", "'.$_REQUEST['TimeToComplete'].'")';
                $db->setQuery($SQL);
                $db->Query();
        foreach($ActivityFields AS $ActivityField)
        {
            if($_REQUEST['origin'] == 'baseline'){
                $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, ExerciseId, RoundNo, ActivityId, AttributeId, AttributeValue) 
                VALUES("'.$_SESSION['UID'].'", "'.$WorkoutTypeId.'", "'.$_REQUEST['WorkoutId'].'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'")';
                $db->setQuery($SQL);
                $db->Query();
            }
            // ExerciseId only applies for benchmarks so we need it here!
            $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId) 
            VALUES("'.$_SESSION['UID'].'", "'.$_REQUEST['WorkoutId'].'", "'.$WorkoutTypeId.'", "'.$ActivityField->RoundNo.'", "'.$ActivityField->ExerciseId.'", "'.$ActivityField->AttributeId.'", "'.$ActivityField->AttributeValue.'", "'.$ActivityField->UnitOfMeasureId.'")';
                $db->setQuery($SQL);
                $db->Query();
            
		}
                $this->Message = 'Success';
            }
            }else{
                $this->Message = 'Error - You are not subscribed!';
            }
        return $this->Message;
	}
             
        function getTopSelection()
        {
            $WodDetails = $this->getWODDetails();
            return $WodDetails;
        }
        
        function getMyGymFeed()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT RG.GymName,
                RG.FeedURL
                FROM Members M
                LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId
                LEFT JOIN RegisteredGyms RG ON RG.recid = MD.GymId
		WHERE M.UserId = '.$_SESSION['UID'].'';
            $db->setQuery($SQL);
            $Row = $db->loadObject();          
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
                    $Row->WodDate = $CurrentNode->nodeValue;
			}  
                return $Row;        
        }
        
        function getGymWodWorkouts()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT WW.recid AS WodId, WT.WODType, WW.WodDate
                FROM WodWorkouts WW
                LEFT JOIN MemberDetails MD ON MD.GymId = WW.GymId
                LEFT JOIN WODTypes WT ON WT.recid = WW.WodTypeId
                WHERE MD.MemberId = "'.$_SESSION['UID'].'"
                AND WodDate = CURDATE()
                GROUP BY WodId
                ORDER BY WodDate';

            $db->setQuery($SQL);
            return $db->loadObjectList();	
        }       
        
         function getWODDetails($WodTypeId)
	{   
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            /*
            $SQL = 'SELECT DISTINCT WT.WodType, WW.WorkoutRoutineTypeId
                FROM WODTypes WT 
                LEFT JOIN WodWorkouts WW ON WW.WodTypeId = WT.recid
                WHERE WW.WodDate = CURDATE()';
            $db->setQuery($SQL);
            $Row = $db->loadObject();
            if($Row->WodType == 'Benchmarks'){
                
 		$SQL = 'SELECT BW.recid,
                        BW.WorkoutName, 
                        E.Exercise, 
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName, 
                        "'.$this->BenchmarkDescription($Row->WorkoutRoutineTypeId).'" AS WorkoutDescription,
                        A.Attribute, 
                        BD.AttributeValueMale, 
                        BD.AttributeValueFemale, 
                        RoundNo,
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Row->WorkoutRoutineTypeId.'") AS TotalRounds
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
			WHERE BD.BenchmarkId = '.$Row->WorkoutRoutineTypeId.'
			ORDER BY RoundNo, OrderBy, Attribute';               
            }else{
                */
             if($this->getGender() == 'M'){
                $AttributeValue = 'AttributeValueMale';
            } else {
                $AttributeValue = 'AttributeValueFemale';
            }  

		$SQL = 'SELECT WD.WodId,
                        WW.WorkoutName, 
                        E.Exercise, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName, 
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                       '.$AttributeValue.' AS AttributeValue,
                        WD.UnitOfMeasureId,   
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,
                        WW.Routine AS RoundNo,
                        WW.WorkoutRoutineTypeId,
                        WW.WodDate,
                        WW.Notes
			FROM WodDetails WD
			LEFT JOIN WodWorkouts WW ON WW.recid = WD.WodId
			LEFT JOIN Exercises E ON E.recid = WD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = WD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.recid = WD.UnitOfMeasureId
			WHERE WW.WodDate = CURDATE() AND WW.WodTypeId = '.$WodTypeId.'
			ORDER BY OrderBy, RoundNo, Exercise, Attribute';
            //}
            //    var_dump($SQL);
            $db->setQuery($SQL);
            return $db->loadObjectList();
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
             if($this->getGender() == 'M'){
                $AttributeValue = 'AttributeValueMale';
            } else {
                $AttributeValue = 'AttributeValueFemale';
            }            
             $SQL = 'SELECT E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                '.$AttributeValue.' AS AttributeValue, 
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
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $db->setQuery($SQL);
            $Rows = $db->loadObjectList();
            $Exercise = '';
            $TotalRounds = '';
            $WorkoutType = '';
            foreach($Rows as $Row)
            {
                if($Exercise != $Row->Exercise){
                    if($Description == ''){
                        if($Row->TotalRounds > 1){
                            $TotalRounds = ''.$Row->TotalRounds.' Rounds | ';
                        }
                        if($Row->WorkoutType == 'Timed')
                            $WorkoutType = 'For Time | ';  
                        else
                            $WorkoutType = ''.$Row->WorkoutType.' | ';
                    }
                    if($Row->Exercise != 'Timed' && $Row->Attribute != 'Reps')
                        $Description .= ''.$Row->Exercise.' | ';
                    $Exercise = $Row->Exercise;
                }
                if($Row->Attribute == 'Reps'){
                    //$Description .= ' ';
                    //$Description .= $Row->AttributeValue;
                    //$Description .= ' ';
                    $Description .= ''.$Row->AttributeValue.' '.$Row->Exercise.' | ';
                }else if($Row->Attribute == 'Weight'){
                    $Description .= ' ';
                    $Description .= $Row->AttributeValue;
                    if($this->getSystemOfMeasure() == 'Metric')
                        $Description .= 'kg';
                    else if($this->getSystemOfMeasure() == 'Imperial')
                        $Description .= 'lbs';
                }else if($Row->Attribute == 'Height'){
                    
                }else if($Row->Attribute == 'Distance'){
                    
                }else if($Row->Attribute == 'TimeToComplete'){
                    
                }else if($Row->Attribute == 'CountDown'){
                    
                }else if($Row->Attribute == 'Rounds'){
                    
                }else if($Row->Attribute == 'Calories'){
                    
                }
            }
            //$Description .= $TotalRounds.$WorkoutType;
            return $TotalRounds.$WorkoutType.$Description;           
        }       
        
        function getFeedDetails()
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT RG.GymName,
                RG.FeedURL
                FROM Members M
                LEFT JOIN MemberDetails MD ON MD.MemberId = M.UserId
                LEFT JOIN RegisteredGyms RG ON RG.recid = MD.GymId
		WHERE M.UserId = '.$_SESSION['UID'].'';
            $db->setQuery($SQL);
            $Row = $db->loadObject();          
            $URL = $Row->FeedURL;
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
                            $Row->WorkoutDescription = $Doc->getElementsByTagName('description')->item($i);                           
                        }
                    } 
		$i++;		
                }               
                return $Row;        
        }        
        
         function getWodDescription($Id)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
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
            $db->setQuery($SQL);
            $Rows = $db->loadObjectList();
            $Exercise = '';
            foreach($Rows as $Row)
            {
                if($Exercise != $Row->Exercise){
                    if($Description == '')
                        $WorkoutType = $Row->WorkoutType;
                    else
                        $Description .= ' | ';
                    if($Row->Exercise != 'Timed')
                        $Description .= $Row->Exercise;
                    $Exercise = $Row->Exercise;
                }
                if($Row->Attribute == 'Reps'){
                    $Description .= ' ';
                    $Description .= $Row->AttributeValue;
                    $Description .= ' ';
                    $Description .= $Row->Attribute;
                }else if($Row->Attribute == 'Weight'){
                    $Description .= ' ';
                    $Description .= $Row->AttributeValue;
                    if($this->getSystemOfMeasure() == 'Metric')
                        $Description .= 'kg';
                    else if($this->getSystemOfMeasure() == 'Imperial')
                        $Description .= 'lbs';
                }else if($Row->Attribute == 'Height'){
                    
                }else if($Row->Attribute == 'Distance'){
                    
                }else if($Row->Attribute == 'TimeToComplete'){
                    
                }else if($Row->Attribute == 'CountDown'){
                    
                }else if($Row->Attribute == 'Rounds'){
                    
                }else if($Row->Attribute == 'Calories'){
                    
                }
            }
            $Description .= $WorkoutType;
            return $Description;           
        }       
			
}
?>