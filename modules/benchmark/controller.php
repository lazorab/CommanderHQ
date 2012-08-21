<?php
class BenchmarkController extends Controller
{
	var $Workout;
	var $BMWS;
	var $Categories;
	var $Category;
        var $Height;
        var $Video;
        var $Exercise;
	
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['UID'])){
                header('location: index.php?module=login');
            }
		$this->Height = floor(SCREENWIDTH * 0.717); 
		$Model = new BenchmarkModel;
		if(isset($_REQUEST['benchmarkId'])){
                    $this->Workout = $Model->getWorkoutDetails($_REQUEST['benchmarkId']);
                    $this->Video = $this->Workout[0]->Video;
                    $this->Exercise = $this->Workout[0]->Name;
                }
		$this->Categories = $Model->getCategories();
		if(isset($_REQUEST['catid'])){
			$this->Category = $Model->getCategory($_REQUEST['catid']);
			if($this->Category != 'Historic'){
				$this->BMWS = $Model->getBMWS($_REQUEST['catid']);
			}
		}
	}
        
        function Video()
        {
            $Html = '<iframe marginwidth="0px" marginheight="0px" width="'.SCREENWIDTH.'" height="'.$this->Height.'" src="http://www.youtube.com/embed/'.$this->Video.'" frameborder="0">';
            return $Html;
        }
	
	function Output()
	{
            $html = '';
            if($_REQUEST['action'] == 'save'){
                $Model = new BenchmarkModel;
		$html .= '<div id="message">'.$Model->Log().'</div>';
                }
	//$RENDER = new Image(SITE_ID);
		$html .= '<br/>';

if(isset($_REQUEST['benchmarkId']))
{
	//var_dump($this->Workout);
    //$Start = $RENDER->NewImage('start.png', $this->Device->GetScreenWidth());
    //$Stop = $RENDER->NewImage('stop.png', $this->Device->GetScreenWidth());
    //$Reset = $RENDER->NewImage('report.png', $this->Device->GetScreenWidth());
    //$Save = $RENDER->NewImage('save.png', $this->Device->GetScreenWidth());
      
	//$html.='<div id="bmdescription">';
	//$html.= str_replace('{br}','<br/>',$this->Workout->Description);
	//$html.='</div>';
	$html.='<form name="form" id="benchmarkform" action="index.php">
        <input type="hidden" name="benchmarkId" value="'.$_REQUEST['benchmarkId'].'"/>
		<input type="hidden" name="wodtype" value="3"/>
		<input type="hidden" name="action" value="save"/>';
	$clock = '';
		$Bhtml = '';
		$Chtml = '';
        $html.='<div class="ui-grid-b">';
        $ThisRound = '';
		$ThisExercise = '';
	foreach($this->Workout as $Benchmark){
		if($Benchmark->Attribute == 'TimeToComplete'){
			$clock = $this->getStopWatch($Benchmark->ExerciseId);
		}
		else if($Benchmark->Attribute == 'CountDown'){
			$clock = $this->getCountDown($Benchmark->AttributeValue);
		}
		else{
			
			if($ThisRound != $Benchmark->RoundNo && $Benchmark->RoundNo > 0){
			
				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}
				
                                $html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a"></div><div class="ui-block-b">Round '.$Benchmark->RoundNo.'</div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="font-size:small">'.$Benchmark->Exercise.'</div>';
			}
			else if($ThisExercise != $Benchmark->Exercise){

				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}
                                if($Benchmark->Exercise == 'Total Rounds'){
                                    $Exercise = '<input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/>';
                                }else{
                                    $Exercise = $Benchmark->Exercise;
                                }
				$html.='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
				$html.='<div class="ui-block-a" style="font-size:small">'.$Exercise.'</div>';
				}
			}	

			
            if($Benchmark->Attribute == 'Height' || $Benchmark->Attribute == 'Distance' || $Benchmark->Attribute == 'Weight'){
				if($Benchmark->Attribute == 'Distance'){
					if($_SESSION['measurement'] == 'imperial')
						$Unit = 'yards';
					else
						$Unit = 'metres';
				}		
				else if($Benchmark->Attribute == 'Weight'){
					if($_SESSION['measurement'] == 'imperial')
						$Unit = 'lbs';
					else
						$Unit = 'kg';
				}
				else if($Benchmark->Attribute == 'Height'){
					if($_SESSION['measurement'] == 'imperial')
						$Unit = 'inches';
					else
						$Unit = 'cm';
				}
                                
				$Bhtml.='<div class="ui-block-b">';
				$Bhtml.='<input class="textinput" size="6" type="number" data-inline="true" name="'.$Benchmark->RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'" value="'.$Benchmark->AttributeValue.'"/> '.$Unit.'';
				$Bhtml.='</div>';		
				if($Chtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
			}
            else if($Benchmark->Attribute == 'Calories' || $Benchmark->Attribute == 'Reps' || $Benchmark->Attribute == 'Rounds'){
                                $InputAttributes = 'class="textinput" type="number" size="6"';
                                if($Benchmark->Attribute == 'Rounds'){
                                    $InputAttributes .= ' id="addround"';
                                }
				$Chtml.='<div class="ui-block-c">';
				$Chtml.='<input '.$InputAttributes.' name="'.$Benchmark->RoundNo.'___'.$Benchmark->ExerciseId.'___'.$Benchmark->Attribute.'" value="'.$Benchmark->AttributeValue.'"/>';
				$Chtml.='</div>';
				if($Bhtml != ''){
					$html.=''.$Bhtml.''.$Chtml.'';
					$Bhtml = '';
					$Chtml = '';
				}
			}
		
		
	$ThisRound = $Benchmark->RoundNo;
	$ThisExercise = $Benchmark->Exercise;
	}
				if($Chtml != '' && $Bhtml == ''){
					$html.='<div class="ui-block-b"></div>'.$Chtml.'';
					$Chtml = '';
					$Bhtml = '';
				}
				if($Chtml == '' && $Bhtml != ''){
					$html.=''.$Bhtml.'<div class="ui-block-c"></div>';
					$Chtml = '';
					$Bhtml = '';
				}	
    $html.='</div>'.$clock.'</form><br/><br/>';		
/*	
    $html.='<div style="margin:0 30% 0 30%; width:50%">
        <img alt="Start" '.$Start.' src="'.ImagePath.'start.png" onclick="start()"/>&nbsp;&nbsp;
        <img alt="Stop" '.$Stop.' src="'.ImagePath.'stop.png" onclick="stop()"/><br/><br/>
        <img alt="Reset" '.$Reset.' src="'.ImagePath.'reset.png" onclick="reset()"/>&nbsp;&nbsp;
        <img alt="Save" '.$Save.' src="'.ImagePath.'save.png" onclick="save()"/>
        </div>';
*/
}
else if(isset($_REQUEST['catid']))
{
	if($this->Category == 'Historic'){
		$html.= $this->getHistory();
	}
	else{
               $html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
                foreach($this->BMWS AS $Exercise){
					$Description = str_replace('{br}',' | ',$Exercise->Description);
					$html .= '<li>
                        <a href="" onclick="getDetails('.$Exercise->Id.');">'.$Exercise->Name.':<br/><span style="font-size:small">'.$Description.'</span></a>
                    </li>';
                }	
				$html .= '</ul><br/>';
	}
/*
	$ImageSize = $RENDER->NewImage('BM_Select.png', $this->Device->GetScreenWidth());
    $explode = explode('"',$ImageSize);
    $height = $explode[1];
	foreach($this->BMWS AS $BMW){ 

		$html.='<div class="benchmark" style="height:'.$height.'px;">
		<div style="width:70%;margin:4% 0 0 4%;float:left;font-size:large;background-color:#fff;">';
		//<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'"">
		$html.=''.$BMW->Name.'';
		//</a>
		$html.='</div>
		<div style="width:15%;margin:0 0.5% 1% 0;background-color:#fff;float:right">';
		//<a href="index.php?module=benchmark&id='.$BMW->Id.'&video='.$BMW->Video.'&banner='.$BMW->Banner.'"">
		$html.='<img onclick="getDetails(\''.$BMW->Id.'\');" '.$ImageSize.' alt="'.$BMW->Name.'" src="'.ImagePath.'BM_Select.png"/>';
		//</a>
		$html.='</div>
		</div>
		<div class="clear"></div>';
		
		//$html.='<h3><a href="index.php?module=benchmark&id='.$BMW->Id.'&banner='.$BMW->Name.'">'.$BMW->Name.'</a></h3>';
	}
	$html.='<br/>';
*/
}
/*
else
{

	$html.=$this->BenchmarkSelection();

	foreach($this->Categories AS $Category){ 
		$ImageSize = $RENDER->NewImage(''.$Category->Image.'.png', $this->Device->GetScreenWidth());
		$html.='<div>';
		//$test='<a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Banner.'">';
		$html.='<img onclick="getBenchmarks(\''.$Category->Id.'\');" '.$ImageSize.' style="margin:2% 5% 3% 5%" alt="'.$Category->Name.'" src="'.ImagePath.''.$Category->Image.'.png"/>';
		//$test='</a>';
		$html.='</div>';	
		//$html.='<h3><a href="index.php?module=benchmark&catid='.$Category->Id.'&banner='.$Category->Name.'">'.$Category->Name.'</a></h3>';
	}
}	
*/
return $html;
	}
	
	function getHistory()
	{
		$Model = new BenchmarkModel;
		$HistoricalData = $Model->getHistory();
		if(empty($HistoricalData)){
			$History = 'Oops! You have not recorded any Benchmark workouts yet.';
		}else{
			foreach($HistoricalData AS $Data){
				$History.=''.$Data->TimeCreated.' : '.$Data->Name.' : '.$Data->AttributeValue.'<br/>';
			}
		}
		return $History;
	}
	
	function TopSelection()
	{
            $Html.='<li>'.$this->Exercise.'</li>';
            return $Html;	
	}
	
	function getStopWatch($ExerciseId)
    {
	$RoundNo = 0;
        $TimeToComplete = '00:00:0';
        if(isset($_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete']))
            $TimeToComplete = $_REQUEST[''.$RoundNo.'___'.$ExerciseId.'___TimeToComplete'];
	$Html.='<input type="text" id="clock" name="'.$RoundNo.'___'.$ExerciseId.'___TimeToComplete" value="'.$TimeToComplete.'"/>';
	$Html.='<input class="buttongroup" type="button" onclick="startstop();" value="Start/Stop"/>';
	$Html.='<input class="buttongroup" type="button" onclick="reset();" value="Reset"/>';
	$Html.='<input class="buttongroup" type="button" onclick="benchmarksubmit();" value="Save"/>';
        
        return $Html;
    }
	
    function getCountDown($Time)
    {
        $Html='<input type="hidden" name="CountDown" value="'.$Time.'"/>';
		$Html.='<input class="buttongroup" type="button" onclick="startstop()" value="Start/Stop"/>';
		$Html.='<input class="buttongroup" type="button" onclick="reset()" value="Reset"/>';
		
        return $Html;
    }	
}
?>