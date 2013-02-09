<?php

require_once('./includes/const.php');

require_once(FRAMEWORK_PATH.'/includes/includes.php');

require_once('./library/controller.class.php');
require_once('./library/model.class.php');

$Module = $_REQUEST['module'];
        
	if (file_exists('modules/'.$Module.'/controller.php')) {
		include('modules/'.$Module.'/controller.php');
		$ControllerClass = ''.$Module.'Controller';
		include('modules/'.$Module.'/model.php');
	}
	else {
		echo 'What the...';
		exit();
	}	
	
	$Ajax = new $ControllerClass;

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'validateform'){
            echo json_encode($Ajax->Message());
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getInputFields'){
            echo json_encode($Ajax->AddNewExercise($_REQUEST['ExerciseId']));
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getAdvancedInputFields'){
            echo json_encode($Ajax->AddNewAdvancedExercise($_REQUEST['ExerciseId']));
        }else if(isset($_REQUEST['topselection'])){
            echo $Ajax->TopSelection();
        }else if(isset($_REQUEST['video'])){
            echo $Ajax->Video();
        }else if(isset($_REQUEST['encode']) && $_REQUEST['encode'] == 'json'){
            echo json_encode($Ajax->Output());
        }
        else{
            echo $Ajax->Output();
        }
	
?>
