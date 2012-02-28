<?php
class VideosController extends Controller
{
	var $Html='';
	
	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');		
			
if($_REQUEST['formsubmitted'] == 'yes')
{
	$i=1;
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
			if ($this->SupportOnlineVideo) {		
				$this->Html.= '<p><a onclick="GetVideo(\''.$Video->SmartPhoneURL.'\')" href="#"><b>'.$Video->Title.'</b></a></p>';
				$this->Html.= '<p>'.$Video->Content.'</p>';
			}else{
				$this->Html.= '<'.$this->Wall.'a href="'.$Video->LegacyPhoneURL.'">'.$Video->Title.'</'.$this->Wall.'a><'.$this->Wall.'br/><'.$this->Wall.'br/>';
			}
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
	
	function CustomHeader()
	{
		if($this->Environment == 'website'){
		$CustomHeader='
		<script type="text/javascript">
    function GetVideo(filename)
    {
        document.getElementById("header").innerHTML = \'<iframe marginwidth="0px" marginheight="0px" width="608" height="436" src="\' + filename + \'" frameborder="0"></iframe>\';
    }
</script>';
}
else{
		$CustomHeader='
		<script type="text/javascript">
    function GetVideo(filename)
    {
        document.getElementById("header").innerHTML = \'<iframe marginwidth="0px" marginheight="0px" width="'.$this->Device->GetScreenWidth().'" height="'.($this->Device->GetScreenWidth() * 0.717).'" src="\' + filename + \'" frameborder="0"></iframe>\';
    }
</script>';
}
		return $CustomHeader;
	}
	
	function Html()
	{
		return $this->Html;
	}
}
?>