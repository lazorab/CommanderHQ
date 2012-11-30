<head>
	<title>Commander HQ</title>
	<meta charset="UTF-8">
<meta name="Description" content="<?php echo $Request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $Request->site->get_keywords();?>" />
<meta http-equiv="cache-control" content="private" />
<meta http-equiv="expires" content="Fri, 30 Dec 2011 12:00:00 GMT" />
<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" />
<meta name="apple-mobile-web-app-capable" content="YES" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />

<link rel="apple-touch-icon" href="images/icon.png" />
	<link rel="apple-touch-icon" href="/images/touch-icon-iphone.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/images/touch-icon-ipad.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/images/touch-icon-iphone4.png">
<!-- startup image for web apps (320x460) -->
<link rel="apple-touch-startup-image" href="/images/splashscreen.png" media="screen and (max-device-width: 320px)" />
<link type="text/css" rel="stylesheet" href="/css/jquery.mobile-1.1.0.min.css" />
<link rel="stylesheet" href="css/website.css">
<link rel="stylesheet" href="/css/add2home.css">
<link rel="stylesheet" href="/css/slideshow.css">
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="/js/stopwatch.js"></script>
<script type="text/javascript" src="/js/slides.min.jquery.js"></script>
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>
<script type="text/javascript">
		var deviceIsAndroid = (window.navigator.userAgent.toLowerCase().search('android') > -1);
		if (deviceIsAndroid) {
			var targetDPI = 160;
			if (window.navigator.userAgent.match(/gt-p10\d0|sgh-i987|sph-p100|sgh-t849|sch-i800|shw-m180s|sc-01c/i)) targetDPI = 'device-dpi';
			document.write('<meta name="viewport" content="target-densityDpi='+targetDPI+',width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />');
		} else {
			document.write('<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />');
		}
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
		$('#menu').show('slow');
	});
	$(document).on("click","img#menuarrow",function(){
		$('#menu').hide('slow');
	});	
	$('#AjaxLoading').html('');
});

function OpenThisPage(page)
{
	$('#AjaxLoading').html('<img src="/css/images/ajax-loader.gif" />');
	window.location = page;
}

</script>
<script type="text/javascript" src="/js/jquery.mobile-1.1.0.min.js"></script>
<script type="text/javascript">
$( document ).bind( 'mobileinit', function(){
  $.mobile.loader.prototype.options.text = "loading";
  $.mobile.loader.prototype.options.textVisible = false;
  $.mobile.loader.prototype.options.theme = "a";
  $.mobile.loader.prototype.options.html = '<img src="/css/images/ajax-loader.gif" />';
});
</script>
</head>