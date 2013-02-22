<?php
require_once('./includes/const.php');
require_once(FRAMEWORK_PATH.'/includes/includes.php');
require_once('./library/image.class.php');
require_once('./library/controller.class.php');
require_once('./library/model.class.php');

$Device = new DeviceManager();

define('SCREENWIDTH',$Device->GetScreenWidth());
if (SCREENWIDTH < 641) {
    define('LAYOUT_WIDTH','640');
}else if(SCREENWIDTH < 981){
    define('LAYOUT_WIDTH','980');
}else{
    define('LAYOUT_WIDTH','1024');
}
define('IMAGE_RENDER_PATH',''.THIS_ADDRESS.'images/'.LAYOUT_WIDTH.'/');

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

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'formsubmit'){
            echo $Ajax->Message();
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'validateform'){
            echo json_encode($Ajax->Message());
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
