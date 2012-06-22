<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $request->site->get_title();?></title>
<meta name="Description" content="<?php echo $request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $request->site->get_keywords();?>" />

<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" />
<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1;"/>
<link id="ctl00_Link1" rel="icon" type="image/x-icon" href="http://images/favicon.ico" />
<link rel="apple-touch-icon" type="image/x-icon" href="http://images/favicon.ico" />
<link type="text/css" rel="stylesheet" href="/css/jquery.mobile-1.1.0.min.css" />
<link type="text/css" rel="stylesheet" href="/css/scrollmenu.css" />
<link href="css/mobiscroll-2.0.custom.min.css" rel="stylesheet" type="text/css" />
<?php echo utility::mobile_stylesheet($request->get_screen_width_new(), 'css/mobile.css');?>
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/js/jquery.color.js"></script>
<script type="text/javascript" src="/js/stopwatch.js"></script>
<script type="text/javascript" src="/js/mobiscroll-2.0.custom.min.js"></script>
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	//Trigger menu drop down
	$("img#menuselect").bind('click', function(){
		//Set vars
		var $MenuTrigger = $('img#menuselect');
		var $Menu = $('#menu');

		//If visible hide else show
		if($Menu.hasClass('active')) {
	    	$MenuTrigger.attr("src", '<?php echo ImagePath;?>menu.png');
	    	$Menu.removeClass('active');
		} else {
	    	$MenuTrigger.attr("src",'<?php echo ImagePath;?>menu_active.png');
	    	$Menu.addClass('active');
			//makeScrollable("div.sc_menu_wrapper", "div.sc_menu");
	    }
	});
                  
    $("img#menuselect").click(function () {
        $("#menu").slideToggle("slow");
    });                  
});	

function makeScrollable(wrapper, scrollable){
	// Get jQuery elements
	var wrapper = $(wrapper), scrollable = $(scrollable);
	
	// Hide images until they are not loaded
	scrollable.hide();
	var loading = $('<div class="loading">Loading...</div>').appendTo(wrapper);
	
	// Set function that will check if all images are loaded
	var interval = setInterval(function(){
		var images = scrollable.find('img');
		var completed = 0;
		
		// Counts number of images that are succesfully loaded
		images.each(function(){
			if (this.complete) completed++;	
		});
		
		if (completed == images.length){
			clearInterval(interval);
			// Timeout added to fix problem with Chrome
			setTimeout(function(){
				
				loading.hide();
				// Remove scrollbars	
				wrapper.css({overflow: 'hidden'});						
				
				scrollable.slideDown('slow', function(){
					enable();	
				});					
			}, 1000);	
		}
	}, 100);
	
	function enable(){			
		// height of area at the top at bottom, that don't respond to mousemove
		var inactiveMargin = 100;
		// Cache for performance
		var wrapperWidth = wrapper.width();
		var wrapperHeight = wrapper.height();
		// Using outer height to include padding too
		var scrollableHeight = scrollable.outerHeight() + 2*inactiveMargin;
		// Do not cache wrapperOffset, because it can change when user resizes window
		// We could use onresize event, but it's just not worth doing that 
		// var wrapperOffset = wrapper.offset();
		
		//When user move mouse over menu			
		wrapper.mousemove(function(e){
			var wrapperOffset = wrapper.offset();
			// Scroll menu
			var top = (e.pageY -  wrapperOffset.top) * (scrollableHeight - wrapperHeight) / wrapperHeight - inactiveMargin;	
			
			if (top < 0){
				top = 0;
			}
			
			wrapper.scrollTop(top);
		});		
	}
}
</script>
</head>
<?php 
echo $htmlOutput->GetOpenBodyTag();
    
if(isset($_REQUEST['banner']))
    $Banner = $_REQUEST['banner'];
else if($_REQUEST['module'] != '' && $_REQUEST['module'] != 'memberhome'){
    $Banner = ''.$_REQUEST['module'].'_header';
}
else
    $Banner = 'header'; 
$Text = 'TestFont';
//$Header = new ImageCreate($Text);
?>

<div id="header">
<img alt="Header" <?php echo $RENDER->NewImage(''.$Banner.'.png', $request->get_screen_width_new());?> src="<?php echo ImagePath.$Banner;?>.png"/>
</div>