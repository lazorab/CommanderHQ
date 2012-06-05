<!DOCTYPE html> 
<html>
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
<link type="text/css" rel="stylesheet" href="/css/jquery.mobile-1.1.0.min.css" />
<link type="text/css" rel="stylesheet" href="/css/menuscroll.css" />
<?php echo utility::mobile_stylesheet($request->get_screen_width_new(), 'css/mobile.css');?>
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.mobile-1.1.0.min.js"></script>
<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/js/jquery.color.js"></script>
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>
<script type="text/javascript" src="/modules/<?php echo $_REQUEST['module'];?>/head.js"></script>
<script type="text/javascript">
    function GetVideo(filename)
    {
		document.getElementById("videobutton").src = '<?php echo $RENDER->Image('video_specific_active.png', $device->GetScreenWidth());?>';
        document.getElementById("video").innerHTML = '<iframe marginwidth="0px" marginheight="0px" width="<?php echo $device->GetScreenWidth();?>" height="<?php echo floor($device->GetScreenWidth() * 0.717);?>" src="' + filename + '" frameborder="0"><\/iframe>';
    }
	

	function MenuAction()
	{
if(document.getElementById("menu").innerHTML == ''){
document.getElementById("menuselect").src = '<?php echo $RENDER->Image("menu_active.png", $request->get_screen_width_new());?>';
getMenu();
}else{	

clearMenu();
	}	
	}
	
	
function clearMenu()
{
	document.getElementById("menuselect").src = '<?php echo $RENDER->Image("menu.png", $request->get_screen_width_new());?>';
	document.getElementById("menu").innerHTML = '';
}

function getMenu()
{
	var menu = '<div id="sidebar">';
menu += '<ul id="menu">';
menu += '<li>Personal</li>';
menu += '<li><a href="?module=register">Register</a></li>';
menu += '<li><a href="?module=goals">Goals</a></li>';
menu += '<li><a href="#">Converter</a></li>';
menu += '<li><a onclick="clearMenu();" href="?module=edit">Profile</a></li>';
menu += '<li>Workouts</span></li>';
menu += '<li><a href="?module=wod">WOD</a></li>';
menu += '<li><a href="?module=benchmark">Benchmark</a></li>';
menu += '<li><a href="?module=baseline">Baseline</a></li>';
menu += '<li><a href="#">Challenge</a></li>';
menu += '</ul>';
menu += '</div>';
	//$('#canvas').inner = menu;
	document.getElementById("menu").innerHTML = menu;
	
	//Background color, mouseover and mouseout
	var colorOver = '#31b8da';
	var colorOut = '#1f1f1f';

	//Padding, mouseover
	var padLeft = '20px';
	var padRight = '20px';
	
	//Default Padding
	var defpadLeft = $('#menu li a').css('paddingLeft');
	var defpadRight = $('#menu li a').css('paddingRight');
		
	//Animate the LI on mouse over, mouse out
	$('#menu li').click(function () {	
		//Make LI clickable
		window.location = $(this).find('a').attr('href');
		
	}).mouseover(function (){
		
		//mouse over LI and look for A element for transition
		$(this).find('a')
		.animate( { paddingLeft: padLeft, paddingRight: padRight}, { queue:false, duration:100 } )
		.animate( { backgroundColor: colorOver }, { queue:false, duration:200 });

	}).mouseout(function () {
	
		//mouse oout LI and look for A element and discard the mouse over transition
		$(this).find('a')
		.animate( { paddingLeft: defpadLeft, paddingRight: defpadRight}, { queue:false, duration:100 } )
		.animate( { backgroundColor: colorOut }, { queue:false, duration:200 });
	});	
	
	//Scroll the menu on mouse move above the #sidebar layer
	$('#sidebar').mousemove(function(e) {

		//Sidebar Offset, Top value
		var s_top = parseInt($('#sidebar').offset().top);		
		
		//Sidebar Offset, Bottom value
		var s_bottom = parseInt($('#sidebar').height() + s_top);
	
		//Roughly calculate the height of the menu by multiply height of a single LI with the total of LIs
		var mheight = parseInt($('#menu li').height() * $('#menu li').length);
	
		//I used this coordinate and offset values for debuggin
		//$('#debugging_mouse_axis').html("X Axis : " + e.pageX + " | Y Axis " + e.pageY);
		//$('#debugging_status').html(Math.round(((s_top - e.pageY)/100) * mheight / 2));
			
		//Calculate the top value
		//This equation is not the perfect, but it 's very close	
		var top_value = Math.round(( (s_top - e.pageY) /100) * mheight / 2);
		
		//Animate the #menu by chaging the top value
		$('#menu').animate({top: top_value}, { queue:false, duration:500});
	});	

}

</script>
</head>
<?php echo $htmlOutput->GetOpenBodyTag();?>
<div class="header" style="background-image:url(<?php echo $RENDER->Image('header_slice.png', $device->GetScreenWidth());?>);repeat-x">
<?php
$Banner = 'header';
if(isset($_REQUEST['module'])){
if($_REQUEST['module'] == 'benchmark')
$Banner = $_REQUEST['module'];
}
if(isset($_REQUEST['banner']))
$Banner = $_REQUEST['banner'];
?>
<img alt="Header" src="<?php echo $RENDER->Image(''.$Banner.'.png', $device->GetScreenWidth());?>"/>
</div>
<?php 