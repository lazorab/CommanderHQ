<script type="text/javascript">

function getWOD()
{    
    $('#AjaxLoading').html('<img <?php echo $RENDER->NewImage("ajax-loader.gif", SCREENWIDTH);?> src="/css/images/ajax-loader.gif" />');
        $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=wod\');" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
	$.getJSON("ajax.php?module=wod",{wod:'display'},display);	
	$.getJSON("ajax.php?module=wod",{topselection:'mygym'},topdisplay);	
}

function getFeedDetails(ThisWorkout)
{
    $('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
    $.getJSON("ajax.php?module=wod",{Workout:ThisWorkout},display);
    $.getJSON("ajax.php?module=wod",{topselection:ThisWorkout},topselectiondisplay);
}

function getDetails(ThisWorkout,ThisWodType)
{
    $('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
    $.getJSON("ajax.php?module=wod",{Workout:ThisWorkout},display);
    $.getJSON("ajax.php?module=wod",{topselection:ThisWorkout},topselectiondisplay);
}

function goBack()
{
	$('#AjaxLoading').html('<img <?php echo $RENDER->NewImage("ajax-loader.gif", SCREENWIDTH);?> src="/css/images/ajax-loader.gif" />');
	$.getJSON("ajax.php?module=wod",{wod:'display'},display);	
	$.getJSON("ajax.php?module=wod",{topselection:'mygym'},topdisplay);
}

function topdisplay(data)
{
    $('#toplist').listview();
    $('#toplist').html(data);
    $('#toplist').listview('refresh');
}

function topselectiondisplay(data)
{
    var codes = '<div class="ui-grid-c">';
    codes += '<div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>';
    codes += '<div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>';
    codes += '<div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>';
    codes += '<div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>';
    codes += '</div>';
    $('#toplist').html(data);
    $('#toplist').listview('refresh'); 
    $('#colorcodes').html(codes);
}

function display(data)
{
    if(data == 'Must First Register Gym!'){
        alert('Must First Register Gym!\nYou will be redirected now');
        window.location = 'index.php?module=profile';
    }
    else{
	$('#AjaxOutput').html(data);
    }
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('.controlbutton').button();
    $('.controlbutton').button('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
    $('#AjaxLoading').html('');	
}
</script>
<br/>
<div id="topselection">
    <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
    <?php echo $Display->TopSelection();?>
    </ul>   
    <div id="colorcodes"></div>
</div>
<div id="AjaxOutput">
	<?php echo $Display->Output();?>
</div>