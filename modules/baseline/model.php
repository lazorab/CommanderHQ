<?php
class BaselineModel extends Model
{
    var $Message;
    function __construct()
    {
	parent::__construct();	
    }
    
    function Log()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        if($this->UserIsSubscribed()){
        if($_REQUEST['newcount'] > 0){
            $this->SaveNewActivities();
        }
        
        $ActivityFields=$this->getActivityFields();
        if($this->Message == ''){
        //var_dump($ActivityFields);
        $WorkoutTypeId = $this->getWorkoutTypeId($_REQUEST['BaselineType']);
        $WorkoutId = $_REQUEST['WorkoutId'];
        foreach($ActivityFields AS $Activity)
        {
            $AttributeValue = '';
            //check to see if we must convert back to metric first for data storage
            if($Activity->Attribute == 'Height' || $Activity->Attribute == 'Distance' || $Activity->Attribute == 'Weight'){
                            
            if($Activity->Attribute == 'Distance'){
                if($this->getSystemOfMeasure() != 'Metric'){
                    $AttributeValue = round($Activity->AttributeValue * 1.61, 2);
                }
            }		
            else if($Activity->Attribute == 'Weight'){
                if($this->getSystemOfMeasure() != 'Metric'){
                    $AttributeValue = round($Activity->AttributeValue * 0.45, 2);
                }
            }
            else if($Activity->Attribute == 'Height'){
                if($this->getSystemOfMeasure() != 'Metric'){
                    $AttributeValue = round($Activity->AttributeValue * 2.54, 2);
                }
            }
            }   
            if($AttributeValue == ''){
                $AttributeValue = $Activity->AttributeValue;
            }
            
            //First Store the values incase they changed
            $SQL = 'UPDATE MemberBaseline 
            SET AttributeValue = "'.$Activity->AttributeValue.'" 
            WHERE MemberId = "'.$_COOKIE['UID'].'" 
            AND ExerciseId = "'.$Activity->ExerciseId.'"
            AND AttributeId = "'.$Activity->Attribute.'"';
            $db->setQuery($SQL);
            $db->Query();
            
            $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, WorkoutId, ExerciseId, AttributeId, AttributeValue) 
            VALUES("'.$_COOKIE['UID'].'", "'.$WorkoutTypeId.'", "'.$WorkoutId.'", "'.$Activity->ExerciseId.'", "'.$Activity->Attribute.'", "'.$Activity->AttributeValue.'")';
            $db->setQuery($SQL);
            $db->Query();
			
            $SQL = 'INSERT INTO WODLog(MemberId, WODTypeId, WorkoutId, ExerciseId, AttributeId, AttributeValue) 
            VALUES("'.$_COOKIE['UID'].'", "'.$WorkoutTypeId.'", "'.$WorkoutId.'", "'.$Activity->ExerciseId.'", "'.$Activity->Attribute.'", "'.$Activity->AttributeValue.'")';
            $db->setQuery($SQL);
            $db->Query();
            $this->Message = 'Success';
        }
        }
            }else{
                $this->Message = 'You are not subscribed!';
            }
        return $this->Message;
        /*
        $SQL = 'SELECT recid, Attribute FROM Attributes';
        $Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
        {
            if(isset($_REQUEST[''.$Row['Attribute'].''])){
                $AttributeValue = $_REQUEST[''.$Row['Attribute'].''];
                $SQL = 'INSERT INTO BaselineLog(MemberId, ExerciseTypeId, ExerciseId, AttributeId, AttributeValue) 
                VALUES("'.$_COOKIE['UID'].'", "'.$ExerciseTypeId.'", "'.$_REQUEST['exercise'].'", "'.$Row['recid'].'", "'.$AttributeValue.'")';
                mysql_query($SQL);	
            }
        }
        */
	}
        
        function getExerciseName($ExerciseId)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT Exercise FROM Exercises WHERE recid = '.$ExerciseId.'';
            $db->setQuery($SQL);
            return $db->loadResult();;
        }    
    
    function MemberBaselineExists()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT MemberId AS MemberRecord FROM MemberBaseline WHERE MemberId = "'.$_COOKIE['UID'].'"';
        $db->setQuery($SQL);
	$db->Query();
        if($db->getNumRows() > 0)
            return true;
        else
            return false;
    }
    
    function SaveNewBaseline()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $DefaultActivities=array('Row'=>'500','Squats'=>'40','Sit-Ups'=>'30','Push-Ups'=>'20','Pull-Ups'=>'10','Timed'=>'00:00:0');
        
        foreach($DefaultActivities AS $key=>$val)
        {
            $SQL='SELECT E.recid AS ExerciseId, A.recid AS AttributeId, "'.$val.'" AS AttributeValue
            FROM Attributes A
            JOIN ExerciseAttributes EA ON EA.AttributeId = A.recid
            JOIN Exercises E ON EA.ExerciseId = E.recid
            WHERE E.Exercise = "'.$key.'"
            AND (A.Attribute = "Distance"
                 OR A.Attribute = "Reps"
                 OR A.Attribute = "TimeToComplete")'; 
            $db->setQuery($SQL);
            $Row = $db->loadObject();
            
            $BaselineTypeId = '1';
            $WorkoutId = '0';
            $ExerciseId = $Row->ExerciseId;
            $AttributeId = $Row->AttributeId;
            $AttributeValue = $Row->AttributeValue;
            $SQL = 'INSERT INTO MemberBaseline(MemberId, BaselineTypeId, WorkoutId, ExerciseId, AttributeId, AttributeValue) VALUES("'.$_COOKIE['UID'].'", "'.$BaselineTypeId.'", "'.$WorkoutId.'", "'.$ExerciseId.'", "'.$AttributeId.'", "'.$AttributeValue.'")';
            $db->setQuery($SQL); 
            $db->Query();
        }
    }
    
    function SaveNewActivities()
    {        
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        for($i=1; $i<$_REQUEST['newcount']; $i++)
        {
            $SQL='SELECT recid FROM Exercises WHERE Exercise = "'.$_REQUEST['newattribute_\'.$i.\''].'"';
            $db->setQuery($SQL);
            $db->Query();
            if($db->getNumRows() > 0){
                $ExerciseId = $db->loadObject();
            }
            else{
                $SQL = 'INSERT INTO Exercises(Exercise) VALUES("'.$_REQUEST['newattribute_\'.$i.\''].'")';
                $db->setQuery($SQL);
                $db->Query();
                $ExerciseId = $db->insertid();
            }
            $SQL = 'INSERT INTO MemberBaseline(MemberId, ExerciseId) VALUES("'.$_COOKIE['UID'].'", '.$ExerciseId.')';
            $db->setQuery($SQL);
            $db->Query();
        }
    }  
	
	function getMemberBaselines()
	{
            $Baselines = array();
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'SELECT MB.recid, 
                MB.WorkoutId,
                BT.BaselineType
                FROM MemberBaseline MB
                JOIN WorkoutTypes BT ON BT.recid = MB.BaselineTypeId
                WHERE MB.MemberId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            $Rows = $db->loadObjectList();	
        
	foreach($Rows AS $Row)
        {
            if($Row->BaselineType == 'Benchmark'){
                $SQL = 'SELECT MB.recid, 
                    BW.WorkoutName AS ActivityName,
                    FROM MemberBaseline MB 
                    JOIN BenchmarkWorkouts BW ON MB.ExerciseId = BW.recid
                    WHERE BW.recid = '.$Row->WorkoutId.'';
            }
            else if($Row->BaselineType == 'Custom'){
                $SQL = 'SELECT MB.recid, 
                CE.ActivityName AS ActivityName
                FROM MemberBaseline MB
                JOIN CustomExercises CE ON CE.recid = MB.ExerciseId
                WHERE CE.recid = '.$Row->WorkoutId.'';               
            }

            $db->setQuery($SQL);
            array_push($Baselines, $db->loadObject());
        }
            return $Baselines;
	}		
    
    function setMemberBaseline()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        if(isset($_REQUEST['benchmark']))
        {
            $WorkoutId = $_REQUEST['benchmark'];
            $BaselineTypeId=$this->getWorkoutTypeId('Benchmark');
        }
        else if(isset($_REQUEST['custom']))
        {
            $WorkoutId = $_REQUEST['custom'];
            $BaselineTypeId=$this->getWorkoutTypeId('Custom');
        }
        $SQL='INSERT INTO MemberBaseline(MemberId, WorkoutId, BaselineTypeId) VALUES("'.$_COOKIE['UID'].'", "'.$WorkoutId.'", "'.$BaselineTypeId.'")';
        $db->setQuery($SQL);
        $db->Query();
        return $db->insertid();
    }
    
    function getWorkoutTypeId($BaselineType)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL='SELECT recid FROM WorkoutTypes WHERE WorkoutType = "'.$BaselineType.'"';
        $db->setQuery($SQL);
        return $db->loadResult();
    }
                       
    function getBaselineDetails()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
        $SQL = 'SELECT DISTINCT MB.WorkoutId, 
            BT.WorkoutType AS BaselineType
            FROM MemberBaseline MB 
            LEFT JOIN WorkoutTypes BT ON BT.recid = MB.BaselineTypeId
            WHERE MB.MemberId = "'.$_COOKIE['UID'].'"'; 

        $db->setQuery($SQL);
        $Row = $db->loadObject();
        if($Row->BaselineType == 'Custom'){
            $BaselineObject = $this->getCustomBaseline($Row->WorkoutId);
        }
        else if($Row->BaselineType == 'Benchmark'){
            $BaselineObject = $this->getBenchmarkBaseline($Row->WorkoutId);
        }     
        else if($Row->BaselineType == 'Baseline'){
            $BaselineObject = $this->getDefaultBaseline();          
        }    
        else{
            $this->SaveNewBaseline();
            $BaselineObject = $this->getDefaultBaseline();      
        }
        return $BaselineObject;
    } 
    
    function getBenchmarkBaseline($Id)
    {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

        if($this->getGender() == 'M'){
            $AttributeValue = 'AttributeValueMale';
        } else {
            $AttributeValue = 'AttributeValueFemale';
		}
		//$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, '.$InputFields.' AS InputFields, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		
		$SQL = 'SELECT BW.recid AS Id,
                        BW.WorkoutName, 
                        E.Exercise,
                        E.recid AS ExerciseId, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName,
                        A.Attribute, 
                        BD.'.$AttributeValue.' AS AttributeValue, 
                        BD.UnitOfMeasureId,    
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,    
                        VideoId, 
                        RoundNo,
                        OrderBy,
                        (SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "'.$Id.'") AS TotalRounds
			FROM BenchmarkDetails BD
			LEFT JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
			LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
			WHERE BD.BenchmarkId = '.$Id.'
			ORDER BY RoundNo, OrderBy, Attribute';
            $db->setQuery($SQL);
		
            return $db->loadObjectList();    
    }
    
    function getCustomBaseline($Id)
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

		$SQL = 'SELECT CW.WorkoutName, 
                        E.Exercise, 
                        CASE 
                            WHEN E.Acronym <> ""
                            THEN E.Acronym
                            ELSE E.Exercise
                        END
                        AS InputFieldName, 
                        "'.$this->getCustomDescription($Id).'" AS WorkoutDescription,
                        E.recid AS ExerciseId, 
                        A.Attribute, 
                        CD.AttributeValue,  
                        CD.UnitOfMeasureId,    
                        UOM.UnitOfMeasure,
                        UOM.ConversionFactor,    
                        RoundNo,
                        OrderBy,
                        (SELECT MAX(RoundNo) FROM CustomDetails WHERE CustomWorkoutId = "'.$Id.'") AS TotalRounds
			FROM CustomDetails CD
			LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
			LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
			LEFT JOIN Attributes A ON A.recid = CD.AttributeId
                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND CD.UnitOfMeasureId = UOM.recid                        
			WHERE CD.CustomWorkoutId = '.$Id.'
			ORDER BY RoundNo, Attribute';
                $db->setQuery($SQL);
                return $db->loadObjectList();       
    }
    
    function getDefaultBaseline()
    {
        $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);

        $SQL = 'SELECT "0" AS WorkoutId, 
            "Default" AS WorkoutName, 
            "Baseline" AS BaselineType, 
            MB.ExerciseId AS ExerciseId, 
            E.Exercise AS Exercise, 
            CASE 
            WHEN E.Acronym <> ""
            THEN E.Acronym
            ELSE E.Exercise
            END
            AS InputFieldName,
            A.Attribute, MB.AttributeValue,
            MB.UnitOfMeasureId,    
            UOM.UnitOfMeasure,
            UOM.ConversionFactor,    
            RoundNo,
            OrderBy,           
            "1" AS TotalRounds
            FROM MemberBaseline MB
            LEFT JOIN Exercises E ON E.recid = MB.ExerciseId
            LEFT JOIN Attributes A ON A.recid = MB.AttributeId
            LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND MB.UnitOfMeasureId = UOM.recid
            WHERE MB.MemberId = "'.$_COOKIE['UID'].'"';
        $db->setQuery($SQL);
        return $db->loadObjectList();
    } 
    
            function getCustomDescription($Id)
        {
            $SQL = 'SELECT E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                CD.AttributeValue, 
                WRT.WorkoutType 
                FROM CustomDetails CD
                LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = CD.AttributeId
                LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
                LEFT JOIN WorkoutRoutineTypes WRT ON WRT.recid = CW.WorkoutRoutineTypeId
                WHERE CD.CustomWorkoutId = "'.$Id.'"
                ORDER BY Exercise';
            
            return $this->MakeDescription($SQL);
        }
                function getBenchmarkDescription($Id)
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
        
        function MakeDescription($SQL)
        {
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $db->setQuery($SQL);
            $Result = $db->loadObjectList();
            $Description = '';
            $Exercise = '';
            $TotalRounds = '';
            $WorkoutType = '';
            foreach($Result AS $Row)
            {
                if($Exercise != $Row->Exercise){
                    if($Description == ''){
                        if($Row->TotalRounds > 1){
                            $TotalRounds = ''.$Row->TotalRounds.' Rounds | ';
                        }
                        if($Row->WorkoutType == 'Timed')
                            $WorkoutType = 'For Time | ';    
                        else if($Row->WorkoutType != 'AMRAP Rounds')
                            $WorkoutType = ''.$Row->WorkoutType.' | ';
                    }

                    $Exercise = $Row->Exercise;
                }
                if($Row->Attribute == 'Reps' && $Row->AttributeValue > 0){
                    $Description .= ''.$Row->AttributeValue.' '.$Row->Exercise.' | ';
                }else if($Row->Exercise != 'Timed'){
                        $Description .= ''.$Row->Exercise.' | ';                   
                }else if($Row->Attribute == 'Weight'){
                    //$Description .= ' ';
                   // $Description .= $Row->AttributeValue;
                    //if($this->getSystemOfMeasure() == 'Metric')
                    //    $Description .= 'kg';
                    //else if($this->getSystemOfMeasure() == 'Imperial')
                    //    $Description .= 'lbs';
                }else if($Row->Attribute == 'Height'){
                    
                }else if($Row->Attribute == 'Distance'){
                    
                }else if($Row->Attribute == 'TimeToComplete'){
                    
                }else if($Row->Attribute == 'CountDown'){
                    
                }else if($Row->Attribute == 'Rounds'){
                    
                }else if($Row->Attribute == 'Calories'){
                    
                }else if($Row->Attribute == 'TimeLimit')
                    $WorkoutType = 'AMRAP In '.$Row->AttributeValue.' | ';                
            }
            //$Description .= $TotalRounds.$WorkoutType;
            return $TotalRounds.$WorkoutType.$Description;           
        }
}
?>