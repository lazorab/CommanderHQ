<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $request->site->get_title();?></title>
<meta name="Description" content="<?php echo $request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $request->site->get_keywords();?>" />
	
<link type="text/css" rel="stylesheet" href="/css/tablet.css"/>
<meta http-equiv="Cache-Control" content="max-age=300" />
<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" /><meta name="viewport" content="width=device-width; user-scalable=no; initial-scale=1.0; maximum-scale=1.0;"/>
<link id="ctl00_Link1" rel="icon" type="image/x-icon" href="http://images/favicon.ico" />
<link rel="apple-touch-icon" type="image/x-icon" href="http://images/favicon.ico" />
<?php echo CustomHeader($_REQUEST['module']);?>
</head>

<div id="header">
	<img alt="Header" src="<?php echo $RENDER->Image('header.png', $request->get_screen_width_new());?>"/>
</div>

<?php	
	function CustomHeader($Module)
	{
	if($Module=='')
		$Module='index';
		$ContollerClass = ''.$Module.'Controller';
		$CustomHeader = new $ContollerClass;
		return $CustomHeader->CustomHeader();
	}
?>