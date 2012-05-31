<?php header('Content-Type: text/xml;charset=UTF-8');?>
<wall:document>
<wall:xmlpidtd />
<head>
	<title><?php echo $request->site->get_title();?></title>
<meta name="Description" content="<?php echo $request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $request->site->get_keywords();?>" />
	
<meta http-equiv="Cache-Control" content="max-age=300" />
<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" />
<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1;"/>
<link id="ctl00_Link1" rel="icon" type="image/x-icon" href="http://images/favicon.ico" />
<link rel="apple-touch-icon" type="image/x-icon" href="http://images/favicon.ico" />
<link type="text/css" rel="stylesheet" href="/css/jquery.mobile.structure-1.1.0.min.css" />
<?php echo utility::mobile_stylesheet($request->get_screen_width_new(), 'css/mobile.css');?>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery.mobile-1.1.0.min.js"></script>
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>
<script type="text/javascript" src="/modules/<?php echo $_REQUEST['module'];?>/head.js">
    function GetVideo(filename)
    {
		document.getElementById("videobutton").innerHTML = '<img alt="Video" src="<?php echo $RENDER->Image('video_specific_active.png', $device->GetScreenWidth());?>"/>';
        document.getElementById("video").innerHTML = '<iframe marginwidth="0px" marginheight="0px" width="<?php echo $device->GetScreenWidth();?>" height="<?php echo $device->GetScreenWidth() * 0.717;?>" src="' + filename + '" frameborder="0"><\/iframe>';
    }
</script>
</head>
<?php echo $htmlOutput->GetOpenBodyTag();	
if($_REQUEST['module'] != 'benchmark'){?>
<div class="header">
	<img alt="Header" src="<?php echo $RENDER->Image('header.png', $request->get_screen_width_new());?>"/>
</div>
<?php	
}
?>