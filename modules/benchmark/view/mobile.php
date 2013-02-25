<?php
$Device = new DeviceManager;
if($Device->IsGoogleAndroidDevice()) { ?>
        <script src="/js/overthrow.js"></script>
<?php } ?>
     
<script type="text/javascript">

$(document).ready(function() {
	//Trigger video
	$("#menuvideo").bind('click', function(){
		//Set vars
 
            var codes = '<div class="ui-grid-c">';
            codes += '<div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>';
            codes += '<div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>';
            codes += '<div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>';
            codes += '<div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>';
            codes += '</div>';
            
            var $VideoTrigger = $('#menuvideo');
            var $Video = $('#video');
		//If visible hide else show
		if($Video.hasClass('active')) {
                    
                $('#colorcodes').html(codes);
                
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific.png');?> src="<?php echo IMAGE_RENDER_PATH;?>video_specific.png"/>');
			
	    	$Video.removeClass('active');
		} else {
                $('#colorcodes').html('');
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific_active.png');?> src="<?php echo IMAGE_RENDER_PATH;?>video_specific_active.png"/>');
	    	$Video.addClass('active');
	    }
	});      
});

function UpdateActivity(ActivityId, Attributes)
{
    var AttributesArray = Attributes.split('_');
    for(i=0; i < AttributesArray.length;i++){
        $("#"+ActivityId+"_"+AttributesArray[i]+"_html").html($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
        $("#"+ActivityId+"_"+AttributesArray[i]+"").val($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
    }  
}
    
function Save()
{
    //var currentround = document.getElementById('addround').value;
    //var currentround = $('#addround').val();
    //$("input:visible[id*='"+currentround+"___146___TimeLimit']").val($('#clock').val());
    $("#TimeToComplete").val($('#clock').html());
    $.getJSON('ajax.php?module=benchmark&action=validateform', $(":checkbox, :hidden").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    var currentround = $('#addround').val();
    if(message == 'Success'){
        var r=confirm("Round "+currentround+" Successfully Saved!\nWould you like to provide us with feedback?");
        if (r==true)
        {
            window.location = 'index.php?module=contact';
        }
        else
        {
            resetclock();
        }
        document.getElementById('addround').value++;
    }  
    else
        alert(message);
}

function getBenchmarks(cat)
{
    $('.toplist').html('');
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=benchmark\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=benchmark',data:{cat:cat},dataType:"html",success:display});
}

function getDetails(id,cat)
{
    $('#back').html('<img alt="Back" onclick="getBenchmarks(\''+cat+'\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    
    $.ajax({url:'ajax.php?module=benchmark',data:{benchmarkId:id,cat:cat},dataType:"html",success:display});  
    $.ajax({url:'ajax.php?module=benchmark',data:{video:id,benchmarkId:id},dataType:"html",success:videodisplay}); 
    $.ajax({url:'ajax.php?module=benchmark',data:{topselection:id,benchmarkId:id},dataType:"html",success:topselectiondisplay});
    
    //var newround = document.getElementById('addround').value;
    //$('[id^=1_]').attr('disabled', false);   
}

function getCustomDetails(id,origin)
{
    $.ajax({url:'ajax.php?module=benchmark',data:{WorkoutId:id, origin:origin},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=benchmark',data:{topselection:id, WorkoutId:id},dataType:"html",success:topselectiondisplay});
}

function topselectiondisplay(data)
{
    var codes = '<div class="ui-grid-c">';
    codes += '<div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>';
    codes += '<div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>';
    codes += '<div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>';
    codes += '<div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>';
    codes += '</div>';
    $('.toplist').html(data);
    
    $('#colorcodes').html(codes);
}

function videodisplay(data)
{
    if(data != ''){
        $('#video').html(data);
        $('#menuvideo').html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific.png');?> src="<?php echo IMAGE_RENDER_PATH;?>video_specific.png"/>');
    }
}

function display(data)
{
    var el = $('#AjaxOutput');
    $('#AjaxOutput').html(data);
    $('.listview').listview();
    $('.listview').listview('refresh'); 
    $('.controlbutton').button();
    $('.controlbutton').button('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
    el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true}); 
    $('#AjaxLoading').html('');	
}

function addRound()
{
    //var rounds = document.getElementById('addround').value; 
    $.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
}
</script>
<br/>

<div id="topselection">
    <ul class="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d"></ul>
</div> 

<div id="video"></div>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>