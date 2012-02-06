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
<?php } ?>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="page" value="vids"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
Search<wall:br/>
<wall:input type="text" name="keyword" value="<?php echo $_REQUEST['keyword'];?>"/>
<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
</wall:form>
<?php
if($_REQUEST['formsubmitted'] == 'yes')
{
	$i=1;
	$keyword = $_REQUEST['keyword'];
	$Video = new Video;

	$VideoSearchResults = $Video->SearchResults($keyword);
	$Total = count($VideoSearchResults);
	if($Total == 0)
		echo '<font style="color:red; font-weight: bold;">No Results</font>';
	else
	{

	if(isset($_REQUEST['limitstart']) && $_REQUEST['limitstart'] > 0)
		$LimitStart=$_REQUEST['limitstart'];
	else
		$LimitStart = 0;
	$Limit = 10;
	$LimitEnd = $LimitStart+$Limit;
	echo '<p>Click on a title below to play video</p>';
	foreach($VideoSearchResults as $Video)
	{
		if($i >= $LimitStart && $i <= $LimitEnd)
		{
			if ($supportOnlineVideoPlay) {		
				echo '<p><a onclick="GetVideo(\''.$Video->SmartPhoneURL.'\')" href="#"><b>'.$Video->Title.'</b></a></p>';
				echo '<p>'.$Video->Content.'</p>';
			}else{
				echo '<wall:a href="'.$Video->LegacyPhoneURL.'">'.$Video->Title.'</wall:a><wall:br/><wall:br/>';
			}
		}
		$i++;
	}
		$href='index.php?page=vids&formsubmitted=yes&keyword='.$keyword.'';
		$pageNav = new Paging( $Total, $LimitStart, $Limit, $href );
?>
<wall:br/>
<center>
<div id="pagelinks">
<?php echo $pageNav->getPagesLinks();?>
</div>
</center>
<?php
	}
}
?>