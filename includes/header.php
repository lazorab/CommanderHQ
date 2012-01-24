<?php
//include all the libraries, both global and local
require_once('includes/includes.php');
session_start();
function HasValue($aValue) {
    return isset($aValue) && trim($aValue) != '';
}
Image();
function Image()
{
	global $RENDER;
	
	$RENDER = new Image(SITE_ID);
}

?>
<wall:document>
<wall:xmlpidtd />
<wall:head>
	<wall:title><?php echo $request->site->get_title();  ?></wall:title>
	<wall:menu_css />
<?php 
    echo '<meta name="Description" content="'.$request->site->get_description().'" />';  
	echo '<meta name="Keywords" content="'.$request->site->get_keywords().'" />';
	
	
    $style_sheet = utility::include_stylesheet(($request->get_screen_width_new()));
	echo $style_sheet;
	
	//If a cookie has been set we can set the session id to the user id
	if($request->cookie['BeMobileUserId_'.$request->get_site_id()] != '')
		$request->session['membermember_id'] = $request->cookie['BeMobileUserId_'.$request->get_site_id()];
		
?>
<link type="text/css" rel="stylesheet" href="style.css"/>
<meta http-equiv="Cache-Control" content="max-age=300" />
<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" /><meta name="viewport" content="width=device-width; user-scalable=no; initial-scale=1.0; maximum-scale=1.0;"/>
<link id="ctl00_Link1" rel="icon" type="image/x-icon" href="http://images/favicon.ico" />
<link rel="apple-touch-icon" type="image/x-icon" href="http://images/favicon.ico" />

</wall:head>

<wall:body>
<div id="header"></div>
<wall:img alt="Header" src="<?php echo $RENDER->Image('img.jpg', $request->get_screen_width_new());?>" />
<wall:br/><wall:br/>
<?php if(isset($_SESSION['UID'])){ ?>
<wall:a href="?page=memberhome">Home</wall:a>
<wall:a href="?page=reports">Reports</wall:a>
<wall:a href="?page=exerciseplan">Exercise Plan</wall:a>
<wall:a href="?page=wod">WOD</wall:a>
<wall:a href="?page=log">Log</wall:a>
<wall:a href="?page=vids">Videos</wall:a>
<?php } else { ?>
<wall:a href="?page=about">About</wall:a>
<wall:a href="?page=map">Map</wall:a>
<wall:a href="?page=register">Register</wall:a>
<wall:a href="?page=login">Login</wall:a>
<?php } ?>