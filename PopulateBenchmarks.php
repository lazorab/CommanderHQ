<?php

mysql_connect('196.3.168.36','bemobile','peTerpanHouse!2012');
@mysql_select_db('bemobile_CrossFit') or die("Unable to select database");

$Query = 'SELECT * FROM tempExercises';
$Result = mysql_query($Query);
$WorkoutName = '';
$RoundNo = 0;
$OrderBy = 1;
while($Row = mysql_fetch_assoc($Result))
{
    if($Row['ElementName'] != ''){
    if($Row['RoutineName'] != $WorkoutName){
        $OrderBy = 1;
        $WorkoutName = $Row['RoutineName'];
    //$CategoryId = "5";
    //$WorkoutTypeId  = "1";
    //$NewQuery = "INSERT INTO BenchmarkWorkouts(WorkoutName,CategoryId,WorkoutTypeId) VALUES('".$WorkoutName."', '".$CategoryId."', '".$WorkoutTypeId."')";
    //mysql_query($NewQuery);
    //echo $NewQuery;
    //echo '<br/>'; 
    //$BenchmarkId = mysql_insert_id();
        $NewQuery = 'SELECT recid FROM BenchmarkWorkouts WHERE WorkoutName = "'.$Row['RoutineName'].'"';
    
    //echo $NewQuery;
    //echo '<br/>'; 
    $NewResult = mysql_query($NewQuery);
    $NewRow = mysql_fetch_assoc($NewResult);
    $BenchmarkId = $NewRow['recid'];

    }
    $WorkoutName = $Row['RoutineName'];
    $NewQuery = 'SELECT recid FROM Exercises WHERE Exercise = "'.$Row['ElementName'].'"';
    
    //echo $NewQuery;
    //echo '<br/>'; 
    $NewResult = mysql_query($NewQuery);
    $NewRow = mysql_fetch_assoc($NewResult);
    $ExerciseId = $NewRow['recid'];

     if($ExerciseId > 0){
       
       if($Row['Rounds'] != $RoundNo){
           $OrderBy = 1;
       }
       $RoundNo = $Row['Rounds'];
    if($Row['Weight'] > 0){
            $NewQuery = 'SELECT recid FROM Attributes WHERE Attribute = "Weight"';
                $NewResult = mysql_query($NewQuery);
    $NewRow = mysql_fetch_assoc($NewResult);
    $AttributeId = $NewRow['recid'];
       $AttributeValueMale = $Row['Weight'];
       $AttributeValueFemale = $Row['Weight'];
    }
    if($Row['Distance'] > 0){
            $NewQuery = 'SELECT recid FROM Attributes WHERE Attribute = "Distance"';
                 $NewResult = mysql_query($NewQuery);
    $NewRow = mysql_fetch_assoc($NewResult);
    $AttributeId = $NewRow['recid'];           
       $AttributeValueMale = $Row['Distance'];
       $AttributeValueFemale = $Row['Distance'];
    }
    if($Row['Reps'] > 0){
            $NewQuery = 'SELECT recid FROM Attributes WHERE Attribute = "Reps"';
                  $NewResult = mysql_query($NewQuery);
    $NewRow = mysql_fetch_assoc($NewResult);
    $AttributeId = $NewRow['recid'];          
       $AttributeValueMale = $Row['Reps'];
       $AttributeValueFemale = $Row['Reps'];
    }

     }
     else{
         echo $Row['Exercise'];
         echo '<br/>';
     }
        $NewQuery = 'INSERT INTO BenchmarkDetails(BenchmarkId,ExerciseId,AttributeId,AttributeValueMale,AttributeValueFemale,RoundNo,OrderBy) VALUES("'.$BenchmarkId.'","'.$ExerciseId.'","'.$AttributeId.'","'.$AttributeValueMale.'","'.$AttributeValueFemale.'","'.$RoundNo.'","'.$OrderBy.'")';
        mysql_query($NewQuery);  
        //echo $NewQuery;
       //echo '<br/>'; 
       $OrderBy++;
    }
}

?>
