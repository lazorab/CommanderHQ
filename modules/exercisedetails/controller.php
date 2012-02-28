<?php
class ExercisedetailsController extends Controller
{
	var $Detail;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
		
		$Member = new Member($_SESSION['UID']);
		$Gender = $Member->Details()->Gender;	
		$Model = new ExercisedetailsModel();
		$this->Detail=$Model->getExercise($_REQUEST['id'], $Gender);		
	}
	
	function Detail()
	{
		$Html='
<'.$this->Wall.'br/>
<h3>'. $this->Detail->Exercise .'</h3>
<h3>Level Requirements</h3>
<h3>Level 1:</h3>';
if($this->Detail->SK1Weight > 0) {
	$Html.='Weight: '. $this->Detail->SK1Weight.' kg<'.$this->Wall.'br/>';
	}
if($this->Detail->SK1Height != '') {
	$Html.='Height: '. $this->Detail->SK1Height.' meters<'.$this->Wall.'br/>';
	}
if($this->Detail->SK1Duration != '') {
	$Html.='Duration: '. $this->Detail->SK1Duration.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK1Reps != '') {
	$Html.='Reps: '. $this->Detail->SK1Reps.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK1Description != '') {
	$Html.='( '. $this->Detail->SK1Description.' )<'.$this->Wall.'br/>';
	}	
$Html.='<'.$this->Wall.'br/><'.$this->Wall.'br/>
<h3>Level 2:</h3>';
if($this->Detail->SK2Weight > 0) {
	$Html.='Weight: '. $this->Detail->SK2Weight.' kg<'.$this->Wall.'br/>';
	}
if($this->Detail->SK2Height != '') {
	$Html.='Height: '. $this->Detail->SK2Height.' meters<'.$this->Wall.'br/>';
	}
if($this->Detail->SK2Duration != '') {
	$Html.='Duration: '. $this->Detail->SK2Duration.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK2Reps != '') {
	$Html.='Reps: '. $this->Detail->SK2Reps.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK2Description != '') {
	$Html.='( '. $this->Detail->SK2Description.' )<'.$this->Wall.'br/>';
	}	
$Html.='<'.$this->Wall.'br/><'.$this->Wall.'br/>
<h3>Level 3:</h3>';
if($this->Detail->SK3Weight > 0) {
	$Html.='Weight: '. $this->Detail->SK3Weight.' kg<'.$this->Wall.'br/>';
	}
if($this->Detail->SK3Height != '') {
	$Html.='Height: '. $this->Detail->SK3Height.' meters<'.$this->Wall.'br/>';
	}
if($this->Detail->SK3Duration != '') {
	$Html.='Duration: '. $this->Detail->SK3Duration.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK3Reps != '') {
	$Html.='Reps: '. $this->Detail->SK3Reps.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK3Description != '') {
	$Html.='( '. $this->Detail->SK3Description.' )<'.$this->Wall.'br/>';
	}	
$Html.='<'.$this->Wall.'br/><'.$this->Wall.'br/>	
<h3>Level 4:</h3>';
if($this->Detail->SK4Weight > 0) {
	$Html.='Weight: '. $this->Detail->SK4Weight.' kg<'.$this->Wall.'br/>';
	}
if($this->Detail->SK4Height != '') {
	$Html.='Height: '. $this->Detail->SK4Height.' meters<'.$this->Wall.'br/>';
	}
if($this->Detail->SK4Duration != '') {
	$Html.='Duration: '. $this->Detail->SK4Duration.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK4Reps != '') {
	$Html.='Reps: '. $this->Detail->SK4Reps.'<'.$this->Wall.'br/>';
	}	
if($this->Detail->SK4Description != '') {
	$Html.='( '. $this->Detail->SK4Description.' )<'.$this->Wall.'br/>';
	}					
		
		return $Html;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>