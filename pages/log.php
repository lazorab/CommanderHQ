<?php
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
Exercise Completed<wall:br/>
<wall:select name="exercise">
<?php echo $DropDown->ExerciseOptions($_REQUEST['exercise']);?>
</wall:select>
<wall:br/>
Weight<wall:br/>
<wall:input type="text" name="weight" value="<?php echo $_REQUEST['weight'];?>"/><wall:br/>
<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
</wall:form>