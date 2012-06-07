<?php
require_once('/home/bemobile/public_html/framework/globalconst.php');
require_once('../../../includes/const.php');
require_once('/home/bemobile/public_html/framework/image.class.php');
$type = $_REQUEST['wodtype'];
$val = $_REQUEST['val'];	
$screenwidth = $_REQUEST['width'];	
$RENDER = new Image(SITE_ID);
	
		$WOD='';
		if($type == 1){//Custom
			$WOD.='Custom';
		}
		else if($type == 2){//RSS Feed from gym
			$WOD.='RSS Feed';
		}
		else if($type == 3){//Benchmarks
			mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
			@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
			if($val > 0){
				$SQL = 'SELECT WorkoutName, WorkoutDescription FROM BenchmarkWorkouts WHERE recid = '.$val.'';
				$Result = mysql_query($SQL);	
				$Row = mysql_fetch_assoc($Result);
				$WOD .= ''.$Row['WorkoutName'].'';
					$Start = $RENDER->Image('start.png', $screenwidth);
	$Stop = $RENDER->Image('stop.png', $screenwidth);
	$Reset = $RENDER->Image('report.png', $screenwidth);
	$Save = $RENDER->Image('save.png', $screenwidth);
	$WOD.='<div id="bmdescription">';
	$WOD.= $Row['WorkoutDescription'];
	$WOD.='</div>';
	$WOD.='<form name="clockform" action="index.php">
	<input type="hidden" name="module" value="wod"/>
	<input type="hidden" name="wodtype" value="3"/>
	<input type="hidden" name="exercise" value="'.$val.'"/>
	<input type="hidden" name="action" value="save"/>
<input id="clock" name="clock" value="00:00:0"/>
</form>	
<div style="margin:0 30% 0 30%; width:50%">
<img alt="Start" src="'.$Start.'" onclick="start()"/>&nbsp;&nbsp;
<img alt="Stop" src="'.$Stop.'" onclick="stop()"/><br/><br/>
<img alt="Reset" src="'.$Reset.'" onclick="reset()"/>&nbsp;&nbsp;
<img alt="Save" src="'.$Save.'" onclick="save()"/>
</div><br/><br/>';	
			}
			else{
				$SQL = 'SELECT recid, Banner, WorkoutName, WorkoutDescription, VideoId FROM BenchmarkWorkouts';
				$Result = mysql_query($SQL);	
				while($Row = mysql_fetch_assoc($Result))
				{
					$WOD .= '<a href="#" onclick="getContent('.$type.', '.$Row['recid'].', '.$screenwidth.');" data-transition="slide">'.$Row['WorkoutName'].'</a><br/><br/>';	
				}
			}

		}

		echo json_encode( $WOD);
		
?>