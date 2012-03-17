<?php
class Quicklog
{
var $ExerciseId;
var $WorkoutId;
var $UID;
var $ExerciseType;
var $Duration;
var $Reps;
var $Weight;
var $Height;
var $Gender;
var $LevelAchieved;
var $OverallLevelAchieved;

function __construct($Details)
{
mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");

$this->UID = $Details['UID'];
$this->Reps = $Details['reps'];
$this->Weight = $Details['weight'];
$this->Height = $Details['height'];
$this->Duration = ''.$Details['hours'].':'.$Details['minutes'].':'.$Details['seconds'].'';

if(isset($Details['exercise']) && $Details['exercise'] != ''){
$this->ExerciseId = $Details['exercise'];
}
elseif(isset($Details['workout']) && $Details['workout'] != ''){
$this->ExerciseId = $Details['workout'];
}

$Sql = 'SELECT ExerciseTypeId FROM SkillsLevel WHERE ExerciseId = '.$this->ExerciseId.'';
$Result = mysql_query($Sql);
$Row = mysql_fetch_assoc($Result);
$this->ExerciseTypeId = $Row['ExerciseTypeId'];

$this->LevelAchieved = $this->ExerciseLevelAchieved();

$Sql = 'INSERT INTO ExerciseLog(MemberId, ExerciseId, ExerciseTypeId, Duration, Reps, Weight, Height, LevelAchieved)
VALUES("'.$this->UID.'", "'.$this->ExerciseId.'", "'.$this->ExerciseTypeId.'", "'.$this->Duration.'","'.$this->Reps.'","'.$this->Weight.'", "'.$this->Height.'", "'.$this->LevelAchieved.'")';
mysql_query($Sql);

$this->OverallLevelAchieved = $this->OverallLevelAchieved();

$Sql = 'SELECT Gender, Height, SkillLevel FROM MemberDetails WHERE MemberId = '.$this->UID.'';
$Result = mysql_query($Sql);
$Row = mysql_fetch_assoc($Result);
$MemberHeight = $Row['Height'];
$this->Gender = $Row['Gender'];
$BMI = round($Details['membersweight'] / ($MemberHeight * $MemberHeight), 2);

if($Details['membersweight'] > 0){
$Sql = 'UPDATE MemberDetails SET Weight = "'.$Details['membersweight'].'", BMI = '.$BMI.' WHERE MemberId = '.$this->UID.'';
mysql_query($Sql);
}
if($Row['SkillLevel'] < $this->OverallLevelAchieved){
$Sql = 'UPDATE MemberDetails SET SkillLevel = '.$this->OverallLevelAchieved.' WHERE MemberId = '.$this->UID.'';
mysql_query($Sql);
}
    }

function ExerciseLevelAchieved()
{
$Level = 0;

$Sql = 'SELECT Weight, Height, Duration, Reps, Description
FROM SkillsLevel4 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelFourId
WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
$Result = mysql_query($Sql);
if(mysql_num_rows($Result) > 0){
$Level = $this->Evaluate(mysql_fetch_assoc($Result),4);
}

if($Level == 0){
$Sql = 'SELECT Weight, Height, Duration, Reps, Description
FROM SkillsLevel3 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelThreeId
WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
$Result = mysql_query($Sql);
if(mysql_num_rows($Result) > 0){
$Level = $this->Evaluate(mysql_fetch_assoc($Result),3);
}
}

if($Level == 0){
$Sql = 'SELECT Weight, Height, Duration, Reps, Description
FROM SkillsLevel2 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelTwoId
WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
$Result = mysql_query($Sql);
if(mysql_num_rows($Result) > 0){
$Level = $this->Evaluate(mysql_fetch_assoc($Result),2);
}
}

if($Level == 0){
$Sql = 'SELECT Weight, Height, Duration, Reps, Description
FROM SkillsLevel1 SL JOIN SkillsLevel SE ON SL.recid = SE.LevelOneId
WHERE SE.ExerciseId = '.$this->ExerciseId.' AND (Gender = "U" OR Gender = "'.$this->Gender.'")';
$Result = mysql_query($Sql);
if(mysql_num_rows($Result) > 0){
$Level = $this->Evaluate(mysql_fetch_assoc($Result),1);
}
}

return $Level;
}

function Evaluate($Row, $EvalLevel)
{
if($Row['Weight'] == null || $Row['Weight'] == '' || $Row['Weight'] <= $this->Weight
|| $Row['Height'] == null || $Row['Height'] == '' || $Row['Height'] <= $this->Height
|| $Row['Duration'] == null || $Row['Duration'] == '' || $Row['Duration'] <= $this->Duration
|| $Row['Reps'] == null || $Row['Reps'] == '' || $Row['Reps'] <= $this->Reps)
$ReturnLevel = $EvalLevel;
else
$ReturnLevel = 0;
return $ReturnLevel;
}

function OverallLevelAchieved()
{
$Level = 4;
$CompletedExercises = array();
$Sql = 'SELECT ExerciseId, MAX(LevelAchieved) FROM ExerciseLog WHERE MemberId = '.$this->UID.' GROUP BY ExerciseId';
$Result = mysql_query($Sql);
while($Row = mysql_fetch_assoc($Result))
{
if($Row['LevelAchieved'] < $Level)
$Level = $Row['LevelAchieved'];
array_push($CompletedExercises,$Row['ExerciseId']);
}

$PendingExercises=array();
$AllExercises = $this->getExercises();
foreach($AllExercises AS $Exercise)
{
if(!in_array($Exercise->Id, $CompletedExercises))
array_push($PendingExercises,$Exercise->Id);
}
if(count($PendingExercises) == 0)
return $Level;
else
return 0;
}

function getExercises()
{
$Exercises=array();
$Sql = 'SELECT recid, Exercise FROM Exercises';
$Result = mysql_query($Sql);
while($Row = mysql_fetch_assoc($Result))
{
array_push($Exercises, new ExercisesObject($Row));
}
return $Exercises;
}
}

class ExercisesObject
{
var $Id;
var $Exercise;

function __construct($Row)
{
$this->Id = $Row['recid'];
$this->Exercise = $Row['Exercise'];
}
}
?>