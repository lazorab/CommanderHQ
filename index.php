<?php
	require_once("includes/includes.php");
	$request = new BRequest();
	//If a cookie has been set we can set the session id to the user id
	if($request->cookie['BeMobileUserId_'.$request->get_site_id()] != '')
		$request->session['membermember_id'] = $request->cookie['BeMobileUserId_'.$request->get_site_id()];
		
	global $RENDER;
	$RENDER = new Image(SITE_ID);	
	session_start();
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

	$Display = new $ControllerClass;
	$Environment = $Display->getEnvironment();

	/*HEADER*/
		if (file_exists("includes/header/$Environment.php")) 
			include("includes/header/$Environment.php");
	/*MENU*/	
		if (file_exists("includes/menu/$Environment.php")) 
			include("includes/menu/$Environment.php");
	/*CONTENT*/	
		if (file_exists("modules/$Module/view/$Environment.php")) 
			include("modules/$Module/view/$Environment.php");
	/*FOOTER*/
		if (file_exists("includes/footer/$Environment.php")) 
			include("includes/footer/$Environment.php");
?>