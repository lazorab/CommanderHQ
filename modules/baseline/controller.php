<?php
class BaselineController extends Controller
{
	var $Baseline;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
	}
	
	function html()
	{
		$Model = new BaselineModel;
		$html='<h3>Baseline Workout</h3>';
		
		if($_REQUEST['form'] == 'submitted')
		{
			$Result = $Model->UpdateBaseline($_REQUEST['baseline']);
			if(!$Result)
				$html.='Error!';
			else
				$html.='Basline Successfully Saved';
		}
		else
		{
			$html.='Enter the details:';
		}
		$Baseline = $Model->GetBaseline()->Description;
		$html.='<'.$this->Wall.'form action="index.php" method="post">
				<'.$this->Wall.'input type="hidden" name="form" value="submitted"/>
				<'.$this->Wall.'input type="hidden" name="module" value="baseline"/>
				<'.$this->Wall.'textarea rows="5" cols="20" name="baseline">'.$Baseline.'</'.$this->Wall.'textarea>
				<'.$this->Wall.'br/><'.$this->Wall.'br/>
				<'.$this->Wall.'input type="submit" name="submit" value="Save"/>
				</'.$this->Wall.'form>';
				
		return $html;
	}
	
	function CustomHeader()
	{
		return $CustomHeader;
	}
}
?>