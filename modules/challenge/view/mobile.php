<script type="text/javascript">

function getChallenge()
{    
    $('#AjaxLoading').html('<img <?php echo $RENDER->NewImage("ajax-loader.gif");?> src="/css/images/ajax-loader.gif" />');
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=challenge\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=challenge',data:{challenge:'display'},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=challenge',data:{topselection:'mygym'},dataType:"html",success:topdisplay});	
}

function getFeedDetails(ThisWorkout)
{
    $('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=challenge',data:{Workout:ThisWorkout},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=challenge',data:{topselection:ThisWorkout},dataType:"html",success:topselectiondisplay});
}

function getDetails(ThisWorkout,ThisWodType)
{
    $('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=challenge',data:{Workout:ThisWorkout},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=challenge',data:{topselection:ThisWorkout},dataType:"html",success:topselectiondisplay});
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

function challengesubmit()
{
    $.getJSON('ajax.php?module=challenge&action=validateform', $("#challengeform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    if(message == 'Success'){
        $( "#popupFeedback" ).popup("open");
        resetclock();
    }  
    else
        alert(message);
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