<wall:document>
<wall:xmlpidtd />
<wall:head>
	<wall:title><?php echo $request->site->get_title();?></wall:title>
	<wall:menu_css />
<meta name="Description" content="<?php echo $request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $request->site->get_keywords();?>" />
	
<?php echo utility::mobile_stylesheet($request->get_screen_width_new(), 'css/mobile.css');?>
	
<meta http-equiv="Cache-Control" content="max-age=300" />
<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" /><meta name="viewport" content="width=device-width; user-scalable=no; initial-scale=1.0; maximum-scale=1.0;"/>
<link id="ctl00_Link1" rel="icon" type="image/x-icon" href="http://images/favicon.ico" />
<link rel="apple-touch-icon" type="image/x-icon" href="http://images/favicon.ico" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>
<?php echo CustomHeader($_REQUEST['module']);?>
</wall:head>

<div id="header">
	<wall:img alt="Header" src="<?php echo $RENDER->Image('header.png', $request->get_screen_width_new());?>"/>
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