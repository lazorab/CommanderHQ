<?php
require_once("includes/includes.php");
session_start();

//$Device = new DeviceManager();
$HtmlOutput = new HTML5CoreManager();	
$Request = new BRequest();

//global $RENDER;
$RENDER = new Image();	

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
$Environment = 'mobile';
?>
<!DOCTYPE html>
<html manifest="manifest.php" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
/*HEADER*/
if (file_exists("includes/header/$Environment.php"))
include("includes/header/$Environment.php");

//echo $HtmlOutput->GetOpenBodyTag();
  
    $Banner = 'header';//default
    if(isset($_REQUEST['banner']))
        $Banner = $_REQUEST['banner'];
    else if($_REQUEST['module'] != '' && $_REQUEST['module'] != 'memberhome'){
        if (file_exists(''.ImagePath.$_REQUEST['module'].'.php'))
        $Banner = ''.$_REQUEST['module'].'_header';
    }
?>
    <body>
<div data-role="page">

<div id="header">
<img alt="Header" <?php echo $RENDER->NewImage(''.$Banner.'.png', SCREENWIDTH);?> src="<?php echo ImagePath.$Banner;?>.png"/>
</div>

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
</div><!-- /page -->
<?php //echo $HtmlOutput->GetCloseBodyTag();?>
    </body>
</html>