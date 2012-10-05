<wall:document>
<wall:xmlpidtd />
<wall:head>
	<wall:title><?php echo $request->site->get_title();?></wall:title>
	<wall:menu_css />
<meta name="Description" content="<?php echo $request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $request->site->get_keywords();?>" />
	
<?php echo utility::mobile_stylesheet($request->get_screen_width_new(), 'css/legacy.css');?>
	
<meta http-equiv="Cache-Control" content="max-age=300" />
<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" /><meta name="viewport" content="width=device-width; user-scalable=no; initial-scale=1.0; maximum-scale=1.0;"/>
<link id="ctl00_Link1" rel="icon" type="image/x-icon" href="http://images/favicon.ico" />
<link rel="apple-touch-icon" type="image/x-icon" href="http://images/favicon.ico" />
</wall:head>
<wall:body>
<?php 
    
    if(isset($_REQUEST['banner']))
    $Banner = $_REQUEST['banner'];
    else if($_REQUEST['module'] != '' && $_REQUEST['module'] != 'memberhome'){
        $Banner = ''.$_REQUEST['module'].'_header';
    }
    else
    $Banner = 'header';    
    ?>

<div class="header">
<img alt="Header" <?php echo $RENDER->NewImage(''.$Banner.'.png', $request->get_screen_width_new());?> src="<?php echo ImagePath.$Banner;?>.png"/>
</div>