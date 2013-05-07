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
    <body class="register">
        <div id="container">
        <div id="wrapper">
   	  <div id="header">
        	<div id="logo"><img src="images/logo.png" /></div>
            <div id="banner">
            	<div id="banner_statement"><?php if(isset($_COOKIE['GID'])){echo $Display->GymDetails()->GymName;
}else{ ?>Login/Register<?php } ?><br/>
            	  <br/>
                  <span class="sub_statement">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi commodo, ipsum sed pharetra gravida, orci magna rhoncus neque, id pulvinar odio lorem non turpis. Nullam sit amet enim. Suspendisse id velit vitae ligula volutpat condimentum. Aliquam erat volutp</span>il<span class="sub_statement">at. Sed quis velit. Nulla facilisi. Nulla libero. Vivamus pharetra posuere sapien.</span>
            	</div>
            </div>   
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


<?php	
/*FOOTER*/
    if (file_exists("includes/footer/$Environment.php"))
include("includes/footer/$Environment.php");
?>
</div><!-- /content -->
</div><!-- /wrapper -->
</div><!-- /container -->

    </body>
</html>