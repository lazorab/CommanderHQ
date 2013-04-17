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
$Environment = 'mobile';
?>
<!DOCTYPE html>
<html manifest="manifest.php" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
/*HEADER*/
if (file_exists("includes/header/$Environment.php"))
include("includes/header/$Environment.php");
  
    $Banner = 'header';//default
    if(isset($_REQUEST['banner']))
        $Banner = $_REQUEST['banner'];
    else if($_REQUEST['module'] != '' && $_REQUEST['module'] != 'memberhome'){
        if (file_exists(''.IMAGE_RENDER_PATH.$_REQUEST['module'].'.php'))
        $Banner = ''.$_REQUEST['module'].'_header';
    }
?>
<body onorientationchange="updateOrientation();">   
    
    
<div data-role="page" class="pages" data-theme="c">
<?php
/*SLIDE MENU*/        
if (file_exists("includes/menu/$Environment.php"))
include("includes/menu/$Environment.php");?> 
      

<div id="header">
<img alt="Header" <?php echo $RENDER->NewImage(''.$Banner.'.png');?> src="<?php echo IMAGE_RENDER_PATH.$Banner;?>.png"/>
</div>
<?php if(isset($_COOKIE['UID'])){
/*NAVBAR*/	
if (file_exists("includes/navbar/$Environment.php"))
include("includes/navbar/$Environment.php");
    }
?>
    <div id="content" style="min-height:<?php echo SCREENWIDTH;?>px">
<?php
/*CONTENT*/
if($Module != 'verify' && isset($_COOKIE['UID']) && $Display->MemberAgreeToTerms() == 0)
    include("modules/terms/view/$Environment.php");
else if (file_exists("modules/$Module/view/$Environment.php"))
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

    </body>
</html>