<?php
class ExerciselogController extends Controller
{
	var $Html='';
	var $Message='';
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
		
$Model = new ExerciselogModel;
if($_REQUEST['formsubmitted'] == 'yes')
{
	if(isset($_REQUEST['workout']) && $_REQUEST['workout'] != '')
	{ 
	$this->Html.='
Workout Completed<'.$this->Wall.'br/>
<'.$this->Wall.'select name="workout">
'.$Model->WorkoutOptions($_REQUEST['workout']).'
</'.$this->Wall.'select><'.$this->Wall.'br/>
<'.$this->Wall.'br/>';

		if($_REQUEST['hours'] == '00' && $_REQUEST['minutes'] == '00' && $_REQUEST['seconds'] == '00'){ 
			$this->Message = 'Must Enter Time';
		}
		elseif(isset($_REQUEST['reps']) && $_REQUEST['reps'] == ''){
			$this->Message = 'Must Enter Number of Rounds';	
		} 
			$this->Html.='
Time to complete<'.$this->Wall.'br/>
<'.$this->Wall.'select name="hours">
<'.$this->Wall.'option value="00">hh</'.$this->Wall.'option>';
		for($i=0;$i<25;$i++){
		$this->Html.='<option value="'.sprintf("%02d", $i).'"';
		if($_REQUEST['hours'] == sprintf("%02d", $i))
			$this->Html.=' selected="selected"';
		$this->Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
	 } 
	 $this->Html.='
</'.$this->Wall.'select> :
<'.$this->Wall.'select name="minutes">
<'.$this->Wall.'option value="00">mm</'.$this->Wall.'option>';
	for($i=0;$i<60;$i++){
		$this->Html.='<option value="'.sprintf("%02d", $i).'"';
		if($_REQUEST['minutes'] == sprintf("%02d", $i))
			$this->Html.=' selected="selected"';
		$this->Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
	}
	$this->Html.='
</'.$this->Wall.'select> :
<'.$this->Wall.'select name="seconds">
<'.$this->Wall.'option value="00">ss</'.$this->Wall.'option>';
	for($i=0;$i<60;$i++){
		$this->Html.='<option value="'.sprintf("%02d", $i).'"';
		if($_REQUEST['seconds'] == sprintf("%02d", $i))
			$this->Html.=' selected="selected"';
		$this->Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
	}
	$this->Html.='
</'.$this->Wall.'select>
<'.$this->Wall.'br/>
Rounds<'.$this->Wall.'br/>
<'.$this->Wall.'input type="text" name="reps" value="'.$_REQUEST['reps'].'"/><'.$this->Wall.'br/>
<'.$this->Wall.'br/>';
	}
	elseif(isset($_REQUEST['exercise']) && $_REQUEST['exercise']!= '')
	{ 
	$this->Html.='
<'.$this->Wall.'br/>
Exercise Completed<'.$this->Wall.'br/>
<'.$this->Wall.'select name="exercise">
'.$Model->ExerciseOptions($_REQUEST['exercise']).'
</'.$this->Wall.'select><'.$this->Wall.'br/>
<'.$this->Wall.'br/>
Weight Lifted<'.$this->Wall.'br/>
<'.$this->Wall.'input type="text" name="weight" value="'.$_REQUEST['weight'].'"/><'.$this->Wall.'br/>
<'.$this->Wall.'br/>
Height Reached<'.$this->Wall.'br/>
<'.$this->Wall.'input type="text" name="height" value="'.$_REQUEST['height'].'"/><'.$this->Wall.'br/>
<'.$this->Wall.'br/>
Reps<'.$this->Wall.'br/>
<'.$this->Wall.'input type="text" name="reps" value="'.$_REQUEST['reps'].'"/><'.$this->Wall.'br/>
<'.$this->Wall.'br/>
Time to complete<'.$this->Wall.'br/>
<'.$this->Wall.'select name="hours">
<'.$this->Wall.'option value="00">hh</'.$this->Wall.'option>';
	for($i=0;$i<25;$i++){ 
	$this->Html.='
		<'.$this->Wall.'option value="'.$Number.'"';
		if($_REQUEST['hours'] == sprintf("%02d", $i))
			$this->Html.=' selected="selected"';
		$this->Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
	 } 
	 $this->Html.='
</'.$this->Wall.'select> :
<'.$this->Wall.'select name="minutes">
<'.$this->Wall.'option value="00">mm</'.$this->Wall.'option>';
	for($i=0;$i<60;$i++){
	$this->Html.='
		<'.$this->Wall.'option value="'.sprintf("%02d", $i).'"';
		if($_REQUEST['minutes'] == sprintf("%02d", $i))
			$this->Html.=' selected="selected"';
		$this->Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
	} 
	$this->Html.='
</'.$this->Wall.'select> :
<'.$this->Wall.'select name="seconds">
<'.$this->Wall.'option value="00">ss</'.$this->Wall.'option>';
	for($i=0;$i<60;$i++){ 
	$this->Html.='
		<'.$this->Wall.'option value="'.sprintf("%02d", $i).'"';
		if($_REQUEST['seconds'] == sprintf("%02d", $i)) 
			$this->Html.=' selected="selected"';
		$this->Html.='>'.sprintf("%02d", $i).'</'.$this->Wall.'option>';
	}
	$this->Html.='
</'.$this->Wall.'select>';
	if(!isset($_REQUEST['hours']) || !isset($_REQUEST['minutes']) || !isset($_REQUEST['seconds'])) 
		$this->Message = 'Must Enter Time';
	elseif(isset($_REQUEST['membersweight']) && $_REQUEST['weight'] == '')
		$this->Message = 'Must Enter Your Weight';
	}
	
	if($_REQUEST['submit'] == 'Submit'){
	if($this->Message == ''){		
		$Success = new QuickLog($_REQUEST);
		if($Success)
			$this->Message = '<'.$this->Wall.'br/>Log Successful';
		else
			$this->Message = '<'.$this->Wall.'br/>Error: Unsuccessful Log';
	}
	}
	else{
		$this->Message = '';
	}	
	$this->Html.='
	<'.$this->Wall.'br/><'.$this->Wall.'br/>
	<'.$this->Wall.'input type="submit" name="submit" value="Submit"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';
}
else
{
$this->Html.='
<'.$this->Wall.'br/><'.$this->Wall.'br/>
Workout Completed<'.$this->Wall.'br/>
<'.$this->Wall.'select name="workout">
'.$Model->WorkoutOptions($_REQUEST['workout']).'
</'.$this->Wall.'select><'.$this->Wall.'br/>
<'.$this->Wall.'br/>
OR
<'.$this->Wall.'br/><'.$this->Wall.'br/>
Exercise Completed<'.$this->Wall.'br/>
<'.$this->Wall.'select name="exercise">
'.$Model->ExerciseOptions($_REQUEST['exercise']).'
</'.$this->Wall.'select><'.$this->Wall.'br/>
<'.$this->Wall.'br/>
<'.$this->Wall.'br/><'.$this->Wall.'br/>
<'.$this->Wall.'input type="submit" name="next" value="Next"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';
	}
	}
	
	function Message()
	{
		return $this->Message;
	}
	
	function Html()
	{
		return $this->Html;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>