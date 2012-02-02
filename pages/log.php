<?php
session_start();
$Validate = new ValidationUtils;
$ErrorMessage = '';
$DropDown = new DropDownMenu;
if($_REQUEST['formsubmitted'] == 'yes')
{
	if($_REQUEST['exercise'] == '')
		$ErrorMessage = 'Must Select Exercise';
	elseif($_REQUEST['weight'] == '')
		$ErrorMessage = 'Must Enter Weight';
		
	if($ErrorMessage == '')
	{		
		$Success = new QuickLog($_REQUEST);
		if($Success)
			echo '<wall:br/>Log Successful';
		else
			$ErrorMessage = '<wall:br/>Error: Unsuccessful Log';
	}
	if($ErrorMessage != ''){
		echo '<wall:br/>'.$ErrorMessage.'';
	}
}
?>
<wall:br/><wall:br/>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="page" value="log"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
<wall:input type="hidden" name="UID" value="<?php echo $_SESSION['UID'];?>"/>
Exercise Completed<wall:br/>
<wall:select name="exercise">
<?php echo $DropDown->ExerciseOptions($_REQUEST['exercise']);?>
</wall:select><wall:br/>
<wall:br/>
Weight<wall:br/>
<wall:input type="text" name="weight" value="<?php echo $_REQUEST['weight'];?>"/><wall:br/>
<wall:br/>
Reps<wall:br/>
<wall:input type="text" name="reps" value="<?php echo $_REQUEST['reps'];?>"/><wall:br/>
<wall:br/>
Duration/time<wall:br/>
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
<wall:br/><wall:br/>
<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
</wall:form>