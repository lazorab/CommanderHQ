<?php

mysql_connect('196.3.168.36','bemobile','peTerpanHouse!2012');
@mysql_select_db('bemobile_CrossFit') or die("Unable to select database");

$Query = 'SELECT * FROM tempExercises';
$Result = mysql_query($Query);
while($Row = mysql_fetch_assoc($Result))
{
    echo $Row['Exercise'];
    /*
    $NewQuery = 'SELECT recid FROM Exercises WHERE Exercise = "'.$Row['Exercise'].'"';
    $NewResult = mysql_query($NewQuery);
    $NewRow = mysql_fetch_assoc($NewResult);
    $Recid = $NewRow['recid'];
    
    if($NewRow['recid'] > 0){
        $Recid = $Row['recid'];
    }
    else{
        $NewQuery = "INSERT INTO Exercises(Exercise,BenchmarkId) VALUES('".$Row["Exercise"]."', '".$Row["BenchmarkId"]."')";
        mysql_query($NewQuery);
        $Recid = mysql_insert_id();
    } 
     
     */
    /*
    if($Row['Weight'] > 0){
        $NewQuery = 'INSERT INTO ExerciseAttributes(ExerciseId,AttributeId) VALUES('.$Recid.', '.$Row['Weight'].')';
        mysql_query($NewQuery);
    }
    if($Row['Height'] > 0){
        $NewQuery = 'INSERT INTO ExerciseAttributes(ExerciseId,AttributeId) VALUES('.$Recid.', '.$Row['Height'].')';
        mysql_query($NewQuery);
    }
    if($Row['Distance'] > 0){
        $NewQuery = 'INSERT INTO ExerciseAttributes(ExerciseId,AttributeId) VALUES('.$Recid.', '.$Row['Distance'].')';
        mysql_query($NewQuery);
    }
    if($Row['Reps'] > 0){
        $NewQuery = 'INSERT INTO ExerciseAttributes(ExerciseId,AttributeId) VALUES('.$Recid.', '.$Row['Reps'].')';
        mysql_query($NewQuery);
    }
    if($Row['Rounds'] > 0){
        $NewQuery = 'INSERT INTO ExerciseAttributes(ExerciseId,AttributeId) VALUES('.$Recid.', '.$Row['Rounds'].')';
        mysql_query($NewQuery);
    }
    if($Row['Calories'] > 0){
        $NewQuery = 'INSERT INTO ExerciseAttributes(ExerciseId,AttributeId) VALUES('.$Recid.', '.$Row['Calories'].')';
        mysql_query($NewQuery);
    }
    if($Row['Timed'] > 0){
        $NewQuery = 'INSERT INTO ExerciseAttributes(ExerciseId,AttributeId) VALUES('.$Recid.', '.$Row['Timed'].')';
        mysql_query($NewQuery);
    }
*/
}

?>
