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
<!-- commanderhq.be-mobile.co.za: ldmUK2i2yiSlCJDFAjmjEvQox6oBjz0maCWNAqRRcjM-->
<!-- crossfit.be-mobile.co.za: -->
<!-- https://accounts.google.com/ManageDomains-->
<!--<meta name="google-site-verification" content="ldmUK2i2yiSlCJDFAjmjEvQox6oBjz0maCWNAqRRcjM" />-->
<link rel="apple-touch-icon" href="images/icon.png" />
<link rel="apple-touch-icon" href="images/touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/touch-icon-iphone4.png">
<!-- startup image for web apps (320x460) -->
<link rel="apple-touch-startup-image" href="images/splashscreen.png" media="screen and (max-device-width: 320px)" />

<link type="text/css" rel="stylesheet" href="css/jquery.mobile-1.1.0.css" />
<link type="text/css" rel="stylesheet" href="css/mobile.css" />
<link type="text/css" rel="stylesheet" href="css/clock.css" />
<link rel="stylesheet" href="css/add2home.css">
	
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="js/stopwatch.js"></script>

<!--<script type="text/javascript" src="/js/slides.min.jquery.js"></script>-->
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>

<style type="text/css">
body { width: <?php echo SCREENWIDTH;?>px;}
#header{width: <?php echo SCREENWIDTH;?>px;}
#nav{width: <?php echo SCREENWIDTH;?>px;}
#menu{width: <?php echo SCREENWIDTH;?>px;}
#content{width: <?php echo SCREENWIDTH;?>px;}
#footer{<?php echo $RENDER->BackgroundImage('purple.png',0,0);?>}
</style>

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

function DisplayStopwatch(Module, RoutineId)
{
    var ExplodedRoutineId = RoutineId.split('_');
    var RoutineNo = ExplodedRoutineId[2];
    if($('#'+RoutineNo+'_timerContainer').html() != ''){
        SaveRoutineTime(Module, RoutineId);
    }else{  
        $('#'+RoutineNo+'_ShowHideClock').val('Save Time');
        var Html = '<div class="clear"></div><div id="clock" onClick="EnterRoutineTime(\''+RoutineId+'\');">00:00:0</div>';
        Html+='<input type="hidden" id="TimeToComplete" name="TimeToComplete" value="00:00:0">';
        Html+='<div class="StopwatchButton"><input id="resetbutton" class="buttongroup" onClick="resetclock();" type="button" value="Reset"/></div>';
        Html+='<div class="StopwatchButton"><input class="buttongroup" type="button" onClick="Start();" value="Start"/></div>';
        Html+='<div class="StopwatchButton"><input class="buttongroup" type="button" onClick="Stop();" value="Stop"/></div><div class="clear"></div>';
        $('#'+RoutineNo+'_timerContainer').html(Html);        
        $('.buttongroup').button();
        $('.buttongroup').button('refresh');        
    }        
}

function SaveRoutineTime(Module, RoutineId)
{
    var ExplodedRoutineId = RoutineId.split('_');
    var RoutineNo = ExplodedRoutineId[2];    
    var FieldName = ''+RoutineId+'_TimeToComplete';
    var RoutineTime = $('#clock').html();
         $('#'+RoutineNo+'_ShowHideClock').val('Time Routine');
        $('#'+RoutineNo+'_timerContainer').html('');
        $('.buttongroup').button();
        $('.buttongroup').button('refresh');   
    $.ajax({url:'ajax.php?module='+Module+'&action=formsubmit',data:{RoutineTime:RoutineTime,TimeFieldName:FieldName},dataType:"html",success:SaveRoutineTimeResult});      
}

function SaveRoutineTimeResult(message)
{
    if(message == 'Success'){
        var r=confirm("Successfully Saved!\nWould you like to provide us with feedback?");
        if (r==true)
        {
            window.location = 'index.php?module=contact';
        }
    }  
    else if(message != '')
        alert(message);    
}

function EnterRoutineTime(WorkoutType, WorkoutId, RoutineNo)
{
    var time=prompt("Please enter time","00:00:0");
    if(time){
        $('#clock').html(time);
        $('#'+WorkoutType+'_'+WorkoutId+'_'+RoutineNo+'_TimeToComplete').val(time); 
    }
}

function EnterActivityTime(ActivityId)
{
    var time=prompt("Please enter time","00:00:0");
    if(time){
        $('#'+ActivityId+'').val(time); 
    }
}

function ShowHideStopwatch()
{
    if($('#timerContainer').hasClass('active')){
        $('#timerContainer').removeClass('active');
    }else{      
        $('#timerContainer').addClass('active');
    }
}

function goBack()
{
    window.history.back();
}

function OpenThisPage(page)
{
    $('#AjaxLoading').html('<img <?php echo $RENDER->NewImage("ajax-loader.gif");?> src="/css/images/ajax-loader.gif" />');
    window.location = page;
}

function SubmitFeedback()
{
    $.getJSON('ajax.php?module=feedback', $("#feedbackform").serialize(),function(callback){$( "#popupFeedback" ).popup( "close" )});
}

</script>

<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>

<script type="text/javascript">
$( document ).bind( 'mobileinit', function(){
$.mobile.loader.prototype.options.text = "loading";
$.mobile.loader.prototype.options.textVisible = false;
$.mobile.loader.prototype.options.theme = "a";
$.mobile.loader.prototype.options.html = '<img <?php echo $RENDER->NewImage("ajax-loader.gif");?> src="/css/images/ajax-loader.gif" />';
});
</script>
</head>