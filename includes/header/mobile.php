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
<link rel="apple-touch-startup-image" href="images/startup-320x460.png" />
<link rel="apple-touch-startup-image" sizes="640x920" href="images/startup-640x920.png" />
<link rel="apple-touch-startup-image" sizes="640x1096" href="images/startup-640x1096.png" />
<link rel="apple-touch-startup-image" sizes="1024x748" href="images/startup-1024x748.png" />
<link rel="apple-touch-startup-image" sizes="768x1004" href="images/startup-768x1004.png" />
<link type="text/css" rel="stylesheet" href="css/jquery.mobile-1.3.1.css" />
<link type="text/css" rel="stylesheet" href="css/nv.d3.css" />
<link type="text/css" rel="stylesheet" href="css/mobile.css" />
<link type="text/css" rel="stylesheet" href="css/clock.css" />
<link rel="stylesheet" href="css/add2home.css">
	
<script src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/stopwatch.js"></script>
<?php if($Device->IsGoogleAndroidDevice()) { ?>
        <script src="/js/overthrow.js"></script>
<?php } ?>
<style type="text/css">
body { width: <?php echo SCREENWIDTH;?>px;}
#header{width: <?php echo SCREENWIDTH;?>px;}
#nav{width: <?php echo SCREENWIDTH;?>px;}
#menu{width: <?php echo SCREENWIDTH;?>px;}
#content{width: <?php echo SCREENWIDTH;?>px;}
#footer{width: <?php echo (SCREENWIDTH - 16);?>px;padding:8px;}
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
$(document).ready(function(){
  $(window).bind('orientationchange', function() {
      if(window.orientation == 90 || window.orientation == -90){
        var NewOrientation = window.location.href.replace('&orientation=portrait','');
        window.location = ''+NewOrientation+'&orientation=landscape';
      }
      else{
        var NewOrientation = window.location.href.replace('&orientation=landscape','');
        window.location = ''+NewOrientation+'&orientation=portrait';
      }
  });
});
    
$( document ).on( "pageinit", ".pages", function() {
	var page = $(this);
	$( ".jqm-navmenu-link" ).on( "click", function() {
            page.find(".jqm-navmenu-panel").panel( "open" );
	});
		
});	

function DisplayStopwatch(Module, RoutineId)
{
    var ExplodedRoutineId = RoutineId.split('_');
    var RoutineNo = ExplodedRoutineId[2];
    if($('#'+RoutineNo+'_timerContainer').html() != ''){
        SaveRoutineTime(Module, RoutineId);
    }else{  
        $('#'+RoutineNo+'_ShowHideClock').val('Save');
        var Html = '<div class="clear"></div><div id="clock" onClick="EnterRoutineTime(\''+RoutineId+'\');">00:00:0</div>';
        Html+='<input type="hidden" id="TimeToComplete" name="TimeToComplete" value="00:00:0">';
        Html+='<div class="ui-grid-b">';
        Html+='<div class="ui-block-a"><button data-icon="refresh" id="resetbutton" class="buttongroup" onClick="resetclock();"></button></div>';
        Html+='<div class="ui-block-b"><button data-icon="arrow-r" class="buttongroup" onClick="Start();"></button></div>';
        Html+='<div class="ui-block-c"><button data-icon="grid" class="buttongroup" onClick="Stop();"></button></div>';
        Html+='</div>';
        Html+='<div class="clear"></div>';
        $('#'+RoutineNo+'_timerContainer').html(Html);        
        $('.buttongroup').button();
        $('.buttongroup').button('refresh');        
    }        
}

function SaveRoutineTime(Module, RoutineId)
{
    var ExplodedRoutineId = RoutineId.split('_');
    var WodTypeId = ExplodedRoutineId[0]; 
    var WodId = ExplodedRoutineId[1]; 
    var RoutineNo = ExplodedRoutineId[2];    
    var FieldName = ''+RoutineId+'_TimeToComplete';
    var RoutineTime = $('#clock').html();
         $('#'+RoutineNo+'_ShowHideClock').val('Timer');
        $('#'+RoutineNo+'_timerContainer').html('');
        $('.buttongroup').button();
        $('.buttongroup').button('refresh');   
    $.ajax({url:'ajax.php?module='+Module+'&action=formsubmit',data:{RoutineTime:RoutineTime,TimeFieldName:FieldName},dataType:"html",success:SaveRoutineTimeResult});      
var formsCollection = document.getElementsByTagName("form");
for(var i=0;i<formsCollection.length;i++)
{
    var Exploded = formsCollection[i].id.split('_');
    if(Exploded[0] == RoutineNo){
    $.ajax({url:'ajax.php?module='+Module+'&action=formsubmit&WorkoutId='+WodId+'&WodTypeId='+WodTypeId+'',data:$('#'+formsCollection[i].id+'').serialize(),dataType:"html"});
    }
}
}

function SaveRoutineTimeResult(message)
{
    if(message == 'Success'){
        $( "#popupFeedback" ).popup("open");
        resetclock();
    }  
    else
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

function EnterActivityTime(Module, ActivityId)
{
    var time=prompt("Please enter time","00:00:0");
    if(time){
        $('#'+ActivityId+'').val(time); 
        $.ajax({url:'ajax.php?module='+Module+'&action=formsubmit',data:{ActivityId:ActivityId, ActivityTime:time},dataType:"html",success:SaveRoutineTimeResult});      
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
    window.location = page;
}

function SubmitFeedback()
{
    $.getJSON('ajax.php?module=feedback', $("#feedbackform").serialize(),function(callback){$( "#popupFeedback" ).popup( "close" )});
}

</script>

<script src="js/jquery.mobile-1.3.1.min.js"></script>

</head>