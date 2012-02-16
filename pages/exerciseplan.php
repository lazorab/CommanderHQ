<p>
Exercise Planning / Goals
</p>

<wall:form action="index.php" method="post">
<wall:input type="hidden" name="page" value="exerciseplan"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
<wall:input type="hidden" name="UID" value="<?php echo $_SESSION['UID'];?>"/>
<?php if($_REQUEST['formsubmitted'] == 'yes')
{
	if($_REQUEST['submit'] == 'New Goal')
	{ ?>
		<wall:br />
		Title<wall:br/>
		<wall:input type="text" name="title" value=""/><wall:br/>
		Description<wall:br/>
		<textarea rows="5" cols="32" name="description"></textarea>
		<wall:br /><wall:br />	
		<wall:input type="submit" name="submit" value="List Goals"/>
		<wall:input type="submit" name="submit" value="Save"/>
<?php } 
	else if($_REQUEST['submit'] == 'List Goals')
	{
		$Action = new Goals;
		$Goals = $Action->getGoals($_SESSION['UID']);
		foreach($Goals AS $Goal)
		{ 
		?>
			<wall:input type="checkbox" name="Goals[]" value="<?php echo $Goal->Id; ?>" <?php if($Goal->Achieved == 1) echo 'disabled="disabled" checked="checked"'; ?>/>
			<wall:a href="index.php?page=exerciseplan&amp;formsubmitted=yes&amp;submit=view&amp;id=<?php echo $Goal->Id; ?>"><?php echo $Goal->Title; ?></wall:a><wall:br/>
		<?php } ?>
		<wall:br/><wall:br/>
		<wall:input type="submit" name="submit" value="New Goal"/>
		<wall:input type="submit" name="submit" value="Save"/>
	<?php }
	elseif($_REQUEST['submit'] == 'view')
	{
		$Action = new Goals;
		$Goal = $Action->getGoal($_REQUEST['id']);
		echo '<h3>'.$Goal->Title.'</h3>';
		echo str_replace(chr(13),'<wall:br/>',$Goal->Description);
		echo '<wall:br/>';
		echo 'Set Date: '.$Goal->SetDate.'';
		echo '<wall:br/>';
		echo 'Date Achieved:';
		if($Goal->Achieved == 1)
			echo $Goal->AchieveDate;
		else
			echo 'Not yet';	?>
		<wall:br/><wall:br/>
		<wall:input type="submit" name="submit" value="New Goal"/>
		<wall:input type="submit" name="submit" value="List Goals"/>
<?php } 
	elseif($_REQUEST['submit'] == 'Save')
	{
		$Action = new Goals;
		if(isset($_REQUEST['description']))
			$Success = $Action->Save($_REQUEST);
		elseif(isset($_REQUEST['Goals']))
			$Success = $Action->Update($_REQUEST);
		if(!$Success)
			echo '<wall:br/>Error Updating<wall:br/>'; 
		else
			echo '<wall:br/>Successfully Updated<wall:br/>';?>
		<wall:input type="submit" name="submit" value="New Goal"/>
		<wall:input type="submit" name="submit" value="List Goals"/>	
	<?php }
}
else
{ ?>
	<wall:input type="submit" name="submit" value="New Goal"/>
	<wall:input type="submit" name="submit" value="List Goals"/>
<?php } ?>
</wall:form>
<wall:br/><wall:br/>