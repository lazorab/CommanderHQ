<head>
	<title><?php echo $request->site->get_title();?></title>
<meta name="Description" content="<?php echo $request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $request->site->get_keywords();?>" />
<meta http-equiv="cache-control" content="private" />
<meta http-equiv="expires" content="Fri, 30 Dec 2011 12:00:00 GMT" />
<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="YES" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<link rel="apple-touch-icon" href="images/icon.png" />
<link rel="apple-touch-startup-image" href="images/splashscreen.png" />
<link type="text/css" rel="stylesheet" href="/css/jquery.mobile-1.1.0.min.css" />
<?php 
    echo utility::mobile_stylesheet($request->get_screen_width_new(), 'css/mobile.css');
?>
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="/js/stopwatch.js"></script>
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>
<script type="text/javascript">
// Mobile Safari in standalone mode
if(("standalone" in window.navigator) && window.navigator.standalone){
    
    // If you want to prevent remote links in standalone web apps opening Mobile Safari, change 'remotes' to true
    var noddy, remotes = true;
    
    document.addEventListener('click', function(event) {
                              
                              noddy = event.target;
                              
                              // Bubble up until we hit link or top HTML element. Warning: BODY element is not compulsory so better to stop on HTML
                              while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
                              noddy = noddy.parentNode;
                              }
                              
                              if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes))
                              {
                              event.preventDefault();
                              document.location.href = noddy.href;
                              }
                              
                              },false);
}
</script>
<script type="text/javascript">

$(document).ready(function() {
	$("#menu").niceScroll();
	$('#menu').hide();
	$(document).on("click","img#menuselect",function(){
		if($('#menu').hasClass('active')) {
			$('img#menuselect').attr("src", '<?php echo ImagePath;?>menu.png');
			$('#menu').hide('slow');
			$('#menu').removeClass('active');
		}else{
			$('img#menuselect').attr("src",'<?php echo ImagePath;?>menu_active.png');
			$('#menu').show('slow');
			$('#menu').addClass('active');   
		}
	});
});

</script>
<script type="text/javascript" src="/js/jquery.mobile-1.1.0.min.js"></script>
</head>