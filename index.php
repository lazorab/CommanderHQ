<?php
	require_once("includes/includes.php");
	session_start();
	
	$device = new DeviceManager();
	$htmlOutput = new HTML5CoreManager();	
	$request = new BRequest();
		
	global $RENDER;
	$RENDER = new Image(SITE_ID);	

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
?>
		
	<div id="canvas" style="width:100%;float:left;color:#fff;background-color:#091f40">
	<div id="menu">
<div class="sc_menu_wrapper">
	<div class="sc_menu">
		Personal
		<a href="?module=register"><img alt="Register" src="<?php echo $RENDER->Image('register_active.png', $request->get_screen_width_new());?>"/></a>
		<a href="?module=goals"><img alt="Goals" src="<?php echo $RENDER->Image('goals.png', $request->get_screen_width_new());?>"/></a>
		<a href="#">Converter</a>
		<a href="?module=edit">Profile</a>
		Workouts
		<a href="?module=wod">WOD</a>
		<a href="?module=benchmark">Benchmark</a>
		<a href="?module=baseline">Baseline</a>
		<a href="#">Challenge</a>
	</div>
</div>
</div>		
	<div id="content" style="float:left;color:#fff;background-color:#091f40">
<?php
	/*CONTENT*/	
		if (file_exists("modules/$Module/view/$Environment.php")) 
			include("modules/$Module/view/$Environment.php");
?>
	</div>
	</div>
	<div class="clear"></div>
<?php		
	/*FOOTER*/
		if (file_exists("includes/footer/$Environment.php")) 
			include("includes/footer/$Environment.php");
		
?>