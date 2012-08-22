<?php

mysql_connect('localhost','bemobile','peTerpanHouse!2012');
@mysql_select_db('bemobile_CrossFit') or die("Unable to select database");

$Query = 'SELECT * FROM SkillsLevel ORDER BY ExerciseId DESC';
$Result = mysql_query($Query);
while($Row = mysql_fetch_assoc($Result))
{
    if($Row['LevelOneId'] > 0){
    $NewQuery = 'SELECT * FROM SkillsLevel1 WHERE recid = "'.$Row['LevelOneId'].'"';
    $NewResult = mysql_query($NewQuery);
    while($NewRow = mysql_fetch_assoc($NewResult)){

    if($NewRow['Weight'] != null || $NewRow['Weight'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  1, "'.$NewRow['Weight'].'", "'.$Row['Gender'].'", 1)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Height'] != null || $NewRow['Height'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  2, "'.$NewRow['Height'].'", "'.$Row['Gender'].'", 1)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Distance'] != null || $NewRow['Distance'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  11, "'.$NewRow['Distance'].'", "'.$Row['Gender'].'", 1)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Reps'] != null || $NewRow['Reps'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  3, "'.$NewRow['Reps'].'", "'.$Row['Gender'].'", 1)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['TimeToComplete'] != null || $NewRow['TimeToComplete'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  7, "'.$NewRow['TimeToComplete'].'", "'.$Row['Gender'].'", 1)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Duration'] != null || $NewRow['Duration'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  5, "'.$NewRow['Duration'].'", "'.$Row['Gender'].'", 1)';
        mysql_query($YetAnotherQuery);
    }
    }
	}
    
	if($Row['LevelTwoId'] > 0){
        $NewQuery = 'SELECT * FROM SkillsLevel2 WHERE recid = "'.$Row['LevelTwoId'].'"';
    $NewResult = mysql_query($NewQuery);
    while($NewRow = mysql_fetch_assoc($NewResult)){

    if($NewRow['Weight'] != null || $NewRow['Weight'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  1, "'.$NewRow['Weight'].'", "'.$Row['Gender'].'", 2)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Height'] != null || $NewRow['Height'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  2, "'.$NewRow['Height'].'", "'.$Row['Gender'].'", 2)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Distance'] != null || $NewRow['Distance'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  11, "'.$NewRow['Distance'].'", "'.$Row['Gender'].'", 2)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Reps'] != null || $NewRow['Reps'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  3, "'.$NewRow['Reps'].'", "'.$Row['Gender'].'", 2)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['TimeToComplete'] != null || $NewRow['TimeToComplete'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  7, "'.$NewRow['TimeToComplete'].'", "'.$Row['Gender'].'", 2)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Duration'] != null || $NewRow['Duration'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  5, "'.$NewRow['Duration'].'", "'.$Row['Gender'].'", 2)';
        mysql_query($YetAnotherQuery);
    }
    }
	}
    
	if($Row['LevelThreeId'] > 0){
        $NewQuery = 'SELECT * FROM SkillsLevel3 WHERE recid = "'.$Row['LevelThreeId'].'"';
    $NewResult = mysql_query($NewQuery);
    while($NewRow = mysql_fetch_assoc($NewResult)){

    if($NewRow['Weight'] != null || $NewRow['Weight'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  1, "'.$NewRow['Weight'].'", "'.$Row['Gender'].'", 3)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Height'] != null || $NewRow['Height'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  2, "'.$NewRow['Height'].'", "'.$Row['Gender'].'", 3)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Distance'] != null || $NewRow['Distance'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  11, "'.$NewRow['Distance'].'", "'.$Row['Gender'].'", 3)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Reps'] != null || $NewRow['Reps'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  3, "'.$NewRow['Reps'].'", "'.$Row['Gender'].'", 3)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['TimeToComplete'] != null || $NewRow['TimeToComplete'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  7, "'.$NewRow['TimeToComplete'].'", "'.$Row['Gender'].'", 3)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Duration'] != null || $NewRow['Duration'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  5, "'.$NewRow['Duration'].'", "'.$Row['Gender'].'", 3)';
        mysql_query($YetAnotherQuery);
    }
    }
    }
	
	if($Row['LevelFourId'] > 0){
        $NewQuery = 'SELECT * FROM SkillsLevel4 WHERE recid = "'.$Row['LevelFourId'].'"';
    $NewResult = mysql_query($NewQuery);
    while($NewRow = mysql_fetch_assoc($NewResult)){

    if($NewRow['Weight'] != null || $NewRow['Weight'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  1, "'.$NewRow['Weight'].'", "'.$Row['Gender'].'", 4)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Height'] != null || $NewRow['Height'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  2, "'.$NewRow['Height'].'", "'.$Row['Gender'].'", 4)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Distance'] != null || $NewRow['Distance'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  11, "'.$NewRow['Distance'].'", "'.$Row['Gender'].'", 4)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Reps'] != null || $NewRow['Reps'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  3, "'.$NewRow['Reps'].'", "'.$Row['Gender'].'", 4)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['TimeToComplete'] != null || $NewRow['TimeToComplete'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  7, "'.$NewRow['TimeToComplete'].'", "'.$Row['Gender'].'", 4)';
        mysql_query($YetAnotherQuery);
    }
    if($NewRow['Duration'] != null || $NewRow['Duration'] != ''){
        $YetAnotherQuery = 'INSERT INTO SkillsLevels(ExerciseId,ExerciseTypeId,AttributeId,AttributeValue,Gender,SkillsLevel) VALUES('.$Row['ExerciseId'].','.$Row['ExerciseTypeId'].',  5, "'.$NewRow['Duration'].'", "'.$Row['Gender'].'", 4)';
        mysql_query($YetAnotherQuery);
    }
    }
    }
	
}

?>