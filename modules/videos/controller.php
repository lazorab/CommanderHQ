<?php
class VideosController extends Controller
{
	var $Html='';
	
	function __construct()
	{
		parent::__construct();
		if(!isset($_COOKIE['UID']))
			header('location: index.php?module=login');		
			
	$i=1;
        if(isset($_REQUEST['keyword'])){
	$keyword = $_REQUEST['keyword'];
	$Model = new VideosModel;

	$VideoSearchResults = $Model->SearchResults($keyword);
	$Total = count($VideoSearchResults);
	if($Total == 0)
		$this->Html.= '<font style="color:red; font-weight: bold;">No Results</font>';
	else
	{

	if(isset($_REQUEST['limitstart']) && $_REQUEST['limitstart'] > 0)
		$LimitStart=$_REQUEST['limitstart'];
	else
		$LimitStart = 0;
	$Limit = 10;
	$LimitEnd = $LimitStart+$Limit;
	$this->Html.= '<p>Click on a title below to play video</p>';
	foreach($VideoSearchResults as $Video)
	{
		if($i >= $LimitStart && $i <= $LimitEnd)
		{
			$this->Html.= '<p><a onclick="GetVideo(\''.$Video->SmartPhoneURL.'\')" href="#"><b>'.$Video->Title.'</b></a></p>';
			$this->Html.= '<p>'.$Video->Content.'</p>';
			/*
			if ($this->SupportOnlineVideo) {		
				$this->Html.= '<p><a onclick="GetVideo(\''.$Video->SmartPhoneURL.'\')" href="#"><b>'.$Video->Title.'</b></a></p>';
				$this->Html.= '<p>'.$Video->Content.'</p>';
			}else{
				$this->Html.= '<'.$this->Wall.'a href="'.$Video->LegacyPhoneURL.'">'.$Video->Title.'</'.$this->Wall.'a><'.$this->Wall.'br/><'.$this->Wall.'br/>';
			}
			*/
		}
		$i++;
	}
		$href='index.php?module=videos&formsubmitted=yes&keyword='.$keyword.'';
		$pageNav = new Paging( $Total, $LimitStart, $Limit, $href );
$this->Html.='		
<'.$this->Wall.'br/>
<center>
<div id="pagelinks">
'.$pageNav->getPagesLinks().'
</div>
</center>';
        }

	}
     }
	
	function Html()
	{
		return $this->Html;
	}
}
?>