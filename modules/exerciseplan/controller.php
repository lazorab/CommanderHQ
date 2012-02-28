<?php
class ExerciseplanController extends Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');	
	}
	
	function html()
	{
		$html='';
		if($_REQUEST['formsubmitted'] == 'yes')
		{
			if($_REQUEST['submit'] == 'New Goal')
			{ 
				$html.='
		<br />
		Title<br/>
		<input type="text" name="title" value=""/><br/>
		Description<wall:br/>
		<textarea rows="5" cols="32" name="description"></textarea>
		<br /><br />	
		<input type="submit" name="submit" value="List Goals"/>
		<input type="submit" name="submit" value="Save"/>';
			} 
			else if($_REQUEST['submit'] == 'List Goals')
			{
				$Model = new ExerciseplanModel;
				$Goals = $Model->getGoals($_SESSION['UID']);
				foreach($Goals AS $Goal)
				{ 
					$html.='
					<input type="checkbox" name="Goals[]" value="'.$Goal->Id.'"';
					if($Goal->Achieved == 1) 
						$html.=' disabled="disabled" checked="checked"'; 
					$html.='/><a href="index.php?module=exerciseplan&formsubmitted=yes&submit=view&id='.$Goal->Id.'">'.$Goal->Title.'</a><br/>';
				} 
				$html.='
					<br/><br/>
					<input type="submit" name="submit" value="New Goal"/>
					<input type="submit" name="submit" value="Save"/>';
			}
	elseif($_REQUEST['submit'] == 'view')
	{
		$Model = new ExerciseplanModel;
		$Goal = $Model->getGoal($_REQUEST['id']);
		$html.= '<h3>'.$Goal->Title.'</h3>';
		$html.= str_replace(chr(13),'<br/>',$Goal->Description);
		$html.= '<br/>';
		$html.= 'Set Date: '.$Goal->SetDate.'';
		$html.='<br/>';
		$html.='Date Achieved:';
		if($Goal->Achieved == 1)
			$html.= $Goal->AchieveDate;
		else
			$html.='Not yet';	
		$html.='	
		<br/><br/>
		<input type="submit" name="submit" value="New Goal"/>
		<input type="submit" name="submit" value="List Goals"/>';
	} 
	elseif($_REQUEST['submit'] == 'Save')
	{
		$Model = new ExerciseplanModel;
		if(isset($_REQUEST['description']))
			$Success = $Model->Save($_REQUEST);
			elseif(isset($_REQUEST['Goals']))
				$Success = $Model->Update($_REQUEST);
				if(!$Success)
					$html.='<br/>Error Updating<wall:br/>'; 
				else
					$html.='<br/>Successfully Updated<wall:br/>';
				$html.='<input type="submit" name="submit" value="New Goal"/>
				<input type="submit" name="submit" value="List Goals"/>';	
			}
		}
		else
		{ 
			$html.='
			<input type="submit" name="submit" value="New Goal"/>
			<input type="submit" name="submit" value="List Goals"/>';
		}
		return $html;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>