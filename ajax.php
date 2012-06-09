<?php
	require_once("includes/includes.php");	

	if( !isset( $_REQUEST['module'] ) )
		$Module = 'index';
	else
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
	
	echo json_encode($Ajax->Output());
?>
