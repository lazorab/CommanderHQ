<?php
	require_once("includes/includes.php");
	session_start();
	
	$device = new DeviceManager();
	$htmlOutput = new HTML5CoreManager();	
	$request = new BRequest();
		
	global $RENDER;
	$RENDER = new Image(SITE_ID);	

	if( !isset( $_REQUEST['module'] ) )
		$Module = 'memberhome';
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
    
    if($Module != 'login'){    
	/*MENU*/	
		if (file_exists("includes/menu/$Environment.php")) 
			include("includes/menu/$Environment.php");
?>
		
	<div id="canvas">
	<div id="menu">
<div class="sc_menu_wrapper">
	<div class="sc_menu">
		<a href="?module=products"><img alt="Store" src="<?php echo $RENDER->Image('menu_store.png', $request->get_screen_width_new());?>"/></a>
		<img alt="Personal" src="<?php echo $RENDER->Image('menu_personal.png', $request->get_screen_width_new());?>"/>
		<a href="?module=register"><img alt="Register" src="<?php echo $RENDER->Image('menu_register_gym.png', $request->get_screen_width_new());?>"/></a>
		<a href="?module=goals"><img alt="Goals" src="<?php echo $RENDER->Image('menu_goals.png', $request->get_screen_width_new());?>"/></a>
		<a href="?module=converter"><img alt="Converter" src="<?php echo $RENDER->Image('menu_converter.png', $request->get_screen_width_new());?>"/></a>
		<a href="?module=edit"><img alt="Profile" src="<?php echo $RENDER->Image('menu_profile.png', $request->get_screen_width_new());?>"/></a>
		<img alt="Workouts" src="<?php echo $RENDER->Image('menu_workouts.png', $request->get_screen_width_new());?>"/>
		<a href="?module=wod"><img alt="WOD" src="<?php echo $RENDER->Image('menu_wodlog.png', $request->get_screen_width_new());?>"/></a>
		<a href="?module=benchmark"><img alt="Benchmarks" src="<?php echo $RENDER->Image('menu_benchmarks.png', $request->get_screen_width_new());?>"/></a>
		<a href="?module=baseline"><img alt="Baseline" src="<?php echo $RENDER->Image('menu_baseline.png', $request->get_screen_width_new());?>"/></a>
		<a href="?module=challenge"><img alt="Challenge" src="<?php echo $RENDER->Image('menu_challenges.png', $request->get_screen_width_new());?>"/></a>
        <a href="?module=foodlog"><img alt="Nutrition" src="<?php echo $RENDER->Image('menu_nutrition.png', $request->get_screen_width_new());?>"/></a>
        <a href="?module=book"><img alt="Booking" src="<?php echo $RENDER->Image('menu_booking.png', $request->get_screen_width_new());?>"/></a>
        <a href="?module=reports"><img alt="Reports" src="<?php echo $RENDER->Image('menu_reports.png', $request->get_screen_width_new());?>"/></a>
        <a href="?module=skills"><img alt="Skills" src="<?php echo $RENDER->Image('menu_skills.png', $request->get_screen_width_new());?>"/></a>
	</div>
</div>
</div>	
<?php } ?>
	<div id="content">
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