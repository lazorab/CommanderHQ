<?php
$Device = new DeviceManager;
if($Device->IsGoogleAndroidDevice()) { ?>
        <script src="/js/overthrow.js"></script>
<?php } ?>
     
<script type="text/javascript">
$('#back').html('<img alt="Back" onclick="OpenThisPage(\'<?php echo $_SERVER ['HTTP_REFERER'];?>\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
  
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
    
function Save()
{
    $("#TimeToComplete").val($('#clock').html());
    $.getJSON('ajax.php?module=completed&action=validateform', $(":checkbox, :hidden").serialize(),messagedisplay);
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

function getBenchmarks(cat)
{
    $('.toplist').html('');
   // $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=completed\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=completed',data:{cat:cat},dataType:"html",success:display});
}

function getWorkoutList(YearMonth)
{
    $.ajax({url:'ajax.php?module=completed',data:{YearMonth:YearMonth},dataType:"html",success:display});
}

function getDetails(typeid,id)
{
//redirect according to type
    if(typeid == 1){//Baseline
        window.location = "?module=baseline&WorkoutId="+id+"";
    }else if(typeid == 2){//Benchmark
        window.location = "?module=benchmark&benchmarkId="+id+"";
    }else if(typeid == 3){//Custom
        window.location = "?module=personal&WorkoutTypeId=3&WorkoutId="+id+"";
    }else if(typeid == 4){//My Gym (treat same as custom?)
        window.location = "?module=personal&WorkoutTypeId=4&WorkoutId="+id+"";
    }
}

function getCustomDetails(id,origin)
{
    $.ajax({url:'ajax.php?module=completed',data:{WorkoutId:id, origin:origin},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=completed',data:{topselection:id, WorkoutId:id},dataType:"html",success:topselectiondisplay});
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
    $('.toplist').listview('refresh'); 
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
    $.getJSON('ajax.php?module=completed', $("#benchmarkform").serialize(),display);
}

function UpdateActivity(ActivityId, Attributes)
{
    var AttributesArray = Attributes.split('_');
    for(i=0; i < AttributesArray.length;i++){
        $("#"+ActivityId+"_"+AttributesArray[i]+"_html").html($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
        $("#"+ActivityId+"_"+AttributesArray[i]+"").val($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
    }  
}

function SaveTheseResults(ActivityForm)
{    
    //ActivityForm = RoutineNo_RoundNo_OrderBy_'.$Activity->ExerciseId.'
   var Detail = ActivityForm.split('_');
   var ExerciseId = Detail[3];   
   //var TimeToComplete = $('#clock').html();
   //var TimeField = ''+Detail[0]+'_'+Detail[1]+'_'+ExerciseId+'_TimeToComplete_0_'+Detail[2]+'';
//1_1_81_Reps_0_1
   $.ajax({url:'ajax.php?module=completed&action=formsubmit',data:$('#'+ActivityForm+'').serialize(),dataType:"html",success:messagedisplay});          
   $.ajax({url:'ajax.php?module=completed',data:{history:'refresh', ExerciseId:ExerciseId},dataType:"html",success:function(html) {
        $('#'+ActivityForm+'_History').html(html);   
   }});      
    //'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy)
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