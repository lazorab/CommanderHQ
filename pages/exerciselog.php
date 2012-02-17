<wall:form action="index.php" method="post">
<wall:input type="hidden" name="page" value="exerciselog"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
<wall:input type="hidden" name="UID" value="<?php echo $_SESSION['UID'];?>"/>
<?php
session_start();
$Validate = new ValidationUtils;
$ErrorMessage = '';
$DropDown = new DropDownMenu;
if($_REQUEST['formsubmitted'] == 'yes')
{
	if(isset($_REQUEST['workout']) && $_REQUEST['workout'] != '')
	{ ?>
Workout Completed<wall:br/>
<wall:select name="workout">
<?php echo $DropDown->WorkoutOptions($_REQUEST['workout']);?>
</wall:select><wall:br/>
<wall:br/>
	<?php
		if($_REQUEST['hours'] == '00' && $_REQUEST['minutes'] == '00' && $_REQUEST['seconds'] == '00'){ 
			$ErrorMessage = 'Must Enter Time';
		if(isset($_REQUEST['reps']) && $_REQUEST['reps'] == '')
			$ErrorMessage = 'Must Enter Number of Rounds';	
			} ?>
Time to complete<wall:br/>
<wall:select name="hours">
<wall:option value="00">hh</wall:option>
	<?php for($i=0;$i<25;$i++){ ?>
		<wall:option value="<?php printf("%02d", $i);?>"<?php if($_REQUEST['hours'] == sprintf("%02d", $i)) echo ' selected="selected"';?>><?php printf("%02d", $i);?></wall:option>
	<?php } ?>
</wall:select> :
<wall:select name="minutes">
<wall:option value="00">mm</wall:option>
<?php for($i=0;$i<60;$i++){ ?>
		<wall:option value="<?php printf("%02d", $i);?>"<?php if($_REQUEST['minutes'] == sprintf("%02d", $i)) echo ' selected="selected"';?>><?php printf("%02d", $i);?></wall:option>
	<?php } ?>
</wall:select> :
<wall:select name="seconds">
<wall:option value="00">ss</wall:option>
<?php for($i=0;$i<60;$i++){ ?>
		<wall:option value="<?php printf("%02d", $i);?>"<?php if($_REQUEST['seconds'] == sprintf("%02d", $i)) echo ' selected="selected"';?>><?php printf("%02d", $i);?></wall:option>
	<?php } ?>
</wall:select>
<wall:br/>
Rounds<wall:br/>
<wall:input type="text" name="reps" value="<?php echo $_REQUEST['reps'];?>"/><wall:br/>
<wall:br/>
	<?php 
	}
	elseif(isset($_REQUEST['exercise']) && $_REQUEST['exercise']!= '')
	{ ?>
<wall:br/>
Exercise Completed<wall:br/>
<wall:select name="exercise">
<?php echo $DropDown->ExerciseOptions($_REQUEST['exercise']);?>
</wall:select><wall:br/>
<wall:br/>
Weight Lifted<wall:br/>
<wall:input type="text" name="weight" value="<?php echo $_REQUEST['weight'];?>"/><wall:br/>
<wall:br/>
Height Reached<wall:br/>
<wall:input type="text" name="height" value="<?php echo $_REQUEST['height'];?>"/><wall:br/>
<wall:br/>
Reps<wall:br/>
<wall:input type="text" name="reps" value="<?php echo $_REQUEST['reps'];?>"/><wall:br/>
<wall:br/>
Time to complete<wall:br/>
<wall:select name="hours">
<wall:option value="00">hh</wall:option>	
<?php for($i=0;$i<25;$i++){ ?>
		<wall:option value="<?php printf("%02d", $i);?>"<?php if($_REQUEST['hours'] == sprintf("%02d", $i)) echo ' selected="selected"';?>><?php printf("%02d", $i);?></wall:option>
	<?php } ?>
</wall:select> :
<wall:select name="minutes">
<wall:option value="00">mm</wall:option>
<?php for($i=0;$i<60;$i++){ ?>
		<wall:option value="<?php printf("%02d", $i);?>"<?php if($_REQUEST['minutes'] == sprintf("%02d", $i)) echo ' selected="selected"';?>><?php printf("%02d", $i);?></wall:option>
	<?php } ?>
</wall:select> :
<wall:select name="seconds">
<wall:option value="00">ss</wall:option>
<?php for($i=0;$i<60;$i++){ ?>
		<wall:option value="<?php printf("%02d", $i);?>"<?php if($_REQUEST['seconds'] == sprintf("%02d", $i)) echo ' selected="selected"';?>><?php printf("%02d", $i);?></wall:option>
	<?php } ?>
</wall:select>
	<?php 
	if(!isset($_REQUEST['hours']) || !isset($_REQUEST['minutes']) || !isset($_REQUEST['seconds'])) 
		$ErrorMessage = 'Must Enter Time';
	if(isset($_REQUEST['membersweight']) && $_REQUEST['weight'] == '')
		$ErrorMessage = 'Must Enter Your Weight';
	}
	
	if($_REQUEST['submit'] == 'Submit'){
	if($ErrorMessage == ''){		
		$Success = new QuickLog($_REQUEST);
		if($Success)
			echo '<wall:br/>Log Successful';
		else
			$ErrorMessage = '<wall:br/>Error: Unsuccessful Log';
	}
	else{
		echo '<wall:br/>'.$ErrorMessage.'';
	}
	} ?>
	<wall:br/><wall:br/>
	<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
<?php }
else
{
?>
<wall:br/><wall:br/>

Workout Completed<wall:br/>
<wall:select name="workout">
<?php echo $DropDown->WorkoutOptions($_REQUEST['workout']);?>
</wall:select><wall:br/>
<wall:br/>
OR
<wall:br/><wall:br/>
Exercise Completed<wall:br/>
<wall:select name="exercise">
<?php echo $DropDown->ExerciseOptions($_REQUEST['exercise']);?>
</wall:select><wall:br/>
<wall:br/>
<wall:br/><wall:br/>
<wall:input type="submit" name="next" value="Next"/><wall:br/><wall:br/>
<?php } ?>

</wall:form>