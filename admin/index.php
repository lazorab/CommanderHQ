<?php

require_once("includes/includes.php");	

if( !isset( $_REQUEST['module'] ) )
$Module = 'login';
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
//$Environment = $Display->getEnvironment();
$Environment = 'website';
?>
<!DOCTYPE html>
<html>
<?php
/*HEADER*/
if (file_exists("includes/header/$Environment.php"))
include("includes/header/$Environment.php");
  
?>
    <body>

<div id="header">
<?php if(isset($_COOKIE['GID'])){
    echo $Display->GymDetails()->GymName;
}else{?>
<img alt="Header" src="<?php echo IMAGE_RENDER_PATH;?>header.png"/>
<?php } ?>
</div>
<?php if(isset($_COOKIE['GID'])){
/*MENU*/	
if (file_exists("includes/menu/$Environment.php"))
include("includes/menu/$Environment.php");
    }
?>
<div id="content">
<?php
/*CONTENT*/	
    if (file_exists("modules/$Module/view/$Environment.php"))
include("modules/$Module/view/$Environment.php");
?>

</div><!-- /content -->
<div class="clear"></div>
<?php	
/*FOOTER*/
    if (file_exists("includes/footer/$Environment.php"))
include("includes/footer/$Environment.php");
?>

    </body>
</html>