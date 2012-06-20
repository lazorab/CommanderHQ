<?php
class SkillsController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
	}
    
    function getExercises()
    {
		$Model = new SkillsModel;
        $Exercises = $Model->getExercises();
        return $Exercises;
    }
	
	function Output()
	{
		$Model = new SkillsModel;

        $Html.='';
		if(isset($_REQUEST['exercise']))
		{	
            $Exercise = $Model->getExercise();
            $Html .= 'Current Skills Level: '.$Exercise->SkillsLevel.'<'.$this->Wall.'br/><'.$this->Wall.'br/>';
            $Html .= 'Record new?<'.$this->Wall.'br/><'.$this->Wall.'br/>';
			$Html .= 'Time to Complete<'.$this->Wall.'br/>';
			$Html .= $Model->TimeInput('Time');
			$Html .= '<'.$this->Wall.'br/>';
			$Html .= 'Update Weight?<'.$this->Wall.'br/>';
			$Html .= $Model->BodyWeight();
			$Html .= '<'.$this->Wall.'br/>';			
            $Attributes = $Model->getAttributes($_REQUEST['exercise']);
            foreach($Attributes AS $Attribute)
            {	
                if($Attribute->Attribute == 'Duration'){
                    $Html .= 'Duration<'.$this->Wall.'br/>';
                    $Html .= $Model->TimeInput('Duration');
                    $Html .= '<'.$this->Wall.'br/>';
                }	
                if($Attribute->Attribute == 'Reps'){
                    $Html .= 'Rounds/Reps<'.$this->Wall.'br/>
                    <'.$this->Wall.'input type="text" name="reps" value="'.$_REQUEST['reps'].'"/>
                    <'.$this->Wall.'br/>';
                }	
                if($Attribute->Attribute == 'Body Weight'){
                    //not sure about this one
                }
                if($Attribute->Attribute == 'Weight'){
                    $Html .= 'Weight Used<'.$this->Wall.'br/>
                    <'.$this->Wall.'input type="text" name="weight" value="'.$_REQUEST['weight'].'"/><'.$this->Wall.'br/>
                    <'.$this->Wall.'br/>';
                }	
                if($Attribute->Attribute == 'Height'){
                    $Html .= 'Height Used/Reached<'.$this->Wall.'br/>
                    <'.$this->Wall.'input type="text" name="height" value="'.$_REQUEST['height'].'"/><'.$this->Wall.'br/>
                    <'.$this->Wall.'br/>';	
                }
            }
			
			if($_REQUEST['submit'] == 'Save'){
				$this->Message = $Model->Validate($_REQUEST['exercise']);
				if($this->Message == ''){		
					$Success = $Model->Log();
					if($Success)
						$this->Message = '<'.$this->Wall.'br/>Log Successful';
					else
						$this->Message = '<'.$this->Wall.'br/>Error: Unsuccessful Log';		
				}
			}
			else{
				$this->Message = '';
			}	
			$Html.='
				<'.$this->Wall.'br/>
				<'.$this->Wall.'input type="submit" name="submit" value="Save"/><'.$this->Wall.'br/><'.$this->Wall.'br/>';
		}

        return $Html;
	}
	
	function Message()
	{
		return $this->Message;
	}
}
?>