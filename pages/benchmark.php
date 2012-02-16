<?php
$device = new DeviceManagerTest;
$supportOnlineVideoPlay = $device->SupportOnlineVideo();
if ($supportOnlineVideoPlay) {
?>
<script type="text/javascript">
    function GetVideo(filename)
    {
        document.getElementById('header').innerHTML = '<iframe marginwidth="0px" marginheight="0px" width="<?php echo $request->get_screen_width(); ?>" height="<?php echo floor($request->get_screen_width() * 0.717); ?>" src="' + filename + '" frameborder="0"></iframe>';
    }
</script>
<?php }
$Action = new BMW;

if(isset($_REQUEST['id']))
{
	$Workout = $Action->getWorkoutDetails($_REQUEST['id']);
	if ($supportOnlineVideoPlay) {		
		echo '<h3>'.$Workout->WorkoutName.'</h3>
		<a onclick="GetVideo(\''.$Workout->SmartVideoLink.'\')" href="#">Click here for video</a><wall:br/><wall:br/>';
	}else{
		echo '<h3>'.$Workout->WorkoutName.'</h3>
		<a onclick="GetVideo(\''.$Workout->LegacyVideoLink.'\')" href="#">Click here for video</a><wall:br/><wall:br/>';
	} ?>
	
	<?php echo str_replace('{br}','<wall:br/>',$Workout->WorkoutDescription);
}
else
{
	$BMWS = $Action->getBMWS($_REQUEST);?>
	<h3>BenchMark Workouts</h3>
	<?php
	foreach($BMWS AS $BMW){ ?>
		<h3><wall:a href="index.php?page=benchmark&amp;id=<?php echo $BMW->Id;?>"><?php echo $BMW->WorkoutName;?></wall:a></h3>
<?php }
}
?>