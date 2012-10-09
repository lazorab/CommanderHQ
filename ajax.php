<?php
	require_once("includes/includes.php");	

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
	
        if($_REQUEST['action'] == 'validateform'){
            echo json_encode($Ajax->Message());
        }else if(isset($_REQUEST['topselection'])){
            echo json_encode($Ajax->TopSelection());
        }else if(isset($_REQUEST['video'])){
            echo json_encode($Ajax->Video());
        }else{
            echo json_encode($Ajax->Output());
        }
	
?>
