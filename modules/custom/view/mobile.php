        <style type="text/css">
			
			.swipeleft {
			
				cursor: -moz-grab;
				
			}
			
			.swipeleft:active {
			
				cursor: -moz-grabbing;
				
			}
</style> 
                       
<script type="text/javascript" src="js/tabatatimer.js"></script>
<script type="text/javascript" src="js/jquery.cj-swipe.js"></script>
<script type='text/javascript'>
var chosenexercises;

//onClick="RemoveFromList(' + i + ')"

			
			function swipeleftaction(direction) {
				
				alert(direction);
			}
	//$(document).bind('pageinit',function(){
        $(document).bind('pageinit',function() {    
            
             $(".swipeleft").unbindSwipe().touchSwipeLeft(swipeleftaction);
            $(document).on("click","#tabata",function(){
            document.getElementById('clockType').value = 'tabata'; 
		var timer = new STTabataTimerViewControllerNew();
		timer.setValues({
			userId: 0,
			presetId: 0,
			presetName: "Tabata",
			prep: 10,
			work: 20,
			rest: 10,
			cycles: 8,
			tabatas: 1,
			soundsOn: 1
		});
                
		timer.setLabels({
			myPresets: "My Presets",
			newPreset: "Create a New Preset",
			save: "Save",
			workout : "workout",
			tabata : "Tabata",
			prepare : "prepare",
			work : "work",
			rest : "rest",
			cycles : "Cycles",
			tabatas : "Tabatas",
			cyclesl : "cycles",
			tabatasl : "tabatas",
			start : "start",
			stop : "stop",
			pause : "pause",
			resume : "resume",
			preset : "Preset",
			sound : "Sound",
			on : "On",
			off : "Off"
		});
                
		timer.setSounds({
			pausingSession : "PausingSession",
			rest : "Rest",
			sessionComplete : "SessionComplete",
			soundOn : "SoundOn",
			startingSession : "StartingSession",
			stoppingSession : "StoppingSession",
			tabataComplete : "TabataComplete",
			work : "Work",
			warning : "Warning2"
		});
                
		timer.loadSounds(function(){
			timer.drawTimer("#timerContainer");
		});
            });
        });

function getContent(selection)
{  
    $.ajax({url:'ajax.php?module=custom',data:{baseline:selection},dataType:"html",success:display});  
}

function getCustomExercise(id)
{
    $.ajax({url:'ajax.php?module=custom',data:{customexercise:id},dataType:"html",success:display});  
}

function messagedisplay(message)
{  
    if(message == 'Success'){
        var r=confirm("Successfully Saved!\nWould you like to provide us with feedback?");
        if (r==true)
        {
            window.location = 'index.php?module=contact';
        }
        else
        {
            reset();
        }
    }  
    else if(message.substring(0,5) == 'Error'){
        alert(message); 
    }
     else{
        var exercise = message;
        SelectionControl(exercise);
        $.ajax({url:'ajax.php?module=custom',data:{dropdown:'refresh',selectedexercise:exercise},dataType:"html",success:dropdownrefresh});  
    }   
}

function dropdownrefresh(data)
{
    $('#exercises').html(data);
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');

    $('.textinput').textinput();
    $('.numberinput').textinput();
}

function SelectionControl(exercise)
{
    $('#add_exercise').html('');
    if(exercise == 'Add New Activity')
        addNewExercise();
    else
        ExerciseInputs(exercise); 
}

function addNewExercise()
{
    var RoundNo = $('#addround').val();
    var OrderBy = $('#Round' + RoundNo + 'Counter').val();
    var Html ='<div class="AddNewActivityAttributes">';
    Html += '<h2>New Activity</h2>';
    Html += '<div style="float:left;margin:0 0 0 0"><input style="width:225px" type="text" id="NewExercise" name="NewExercise" value="" placeholder="Activity Name"/></div>';
    Html += '<div style="float:left;margin:20px 0 0"><input style="width:225px" type="text" id="Acronym" name="Acronym" value="" placeholder="Acronym for Activity?"/></div>';
    Html += '<div style="float:left;margin:20px 30px 0 0"><input style="width:80px" placeholder="Weight in <?php echo $Display->UserUnitOfMeasure('Weight');?>" type="number" id="NewActivityWeight" name="NewActivityWeight"/></div>';
    Html += '<div style="float:left;margin:20px 0 0 25px"><input style="width:80px" placeholder="Height in <?php echo $Display->UserUnitOfMeasure('Height');?>" type="number" id="NewActivityHeight" name="NewActivityHeight"/></div>';
    Html += '<div style="float:left;margin:20px 30px 0 0"><input style="width:80px" placeholder="Distance" type="number" id="NewActivityDistance" name="NewActivityDistance"/></div>';
    Html += '<div style="float:left;margin:20px 0 0 25px"><select style="width:90px" id="NewActivityDistanceUOM" name="NewActivityDistanceUOM">';
    if('<?php echo $Display->SystemOfMeasure();?>' == 'Metric'){
        Html += '<option value="2">Metres</option>';
        Html += '<option value="1">Kilometres</option>';
        Html += '</select>';               
    }else{
        Html += '<option value="3">Miles</option>';
        Html += '<option value="4">Yards</option>';
        Html += '</select>';                
    } 
    Html += '</div><div class="clear"></div>';

    Html += '<div style="float:left;margin:20px 25px 0 0"><input style="width:80px" type="number" id="NewActivityReps" placeholder="Reps" name="NewActivityReps"/></div>';

    Html += '<div style="float:right;margin:20px 5px 0 0"><input class="buttongroup" type="button" id="" name="btn" onClick="addnew(\''+RoundNo+'\', \''+OrderBy+'\');" value="Add Activity"/></div>';
    Html += '</div><div class="clear"></div>';

    $('#add_exercise').html(Html);

    $('.textinput').textinput();
    $('.numberinput').textinput();
}

function addactivitydisplay(data)
{
if(data.substring(0,5) == 'Error'){
        alert(data); 
    }
     else{    
    var RoundNo = $('#addround').val();
    document.getElementById('rowcounter').value++;
    document.getElementById('Round' + RoundNo + 'Counter').value++;
    var RowNo = $('#rowcounter').val();
    var Html = data.replace(/RowNo/g, RowNo);
    $('#add_exercise').html('');
    $('#ExerciseInputs').html('');
    if(RoundNo == 1)
        chosenexercises += Html;
    Html = Html.replace(/RoundNo/g, RoundNo);
    $('#activity_list').append(Html);
    $("#exercises option[value='none']").attr("selected","selected");
    var el = $('#AjaxOutput');
    el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true});
    $('.listview').listview();
    $('.listview').listview('refresh');
     }
}

function OpenHistory(ExerciseId)
{
    if($('#'+ExerciseId+'').hasClass('active')){
        $('#'+ExerciseId+'').removeClass('active');
    }else{
        $('#'+ExerciseId+'').addClass('active');
    } 
}

function ExerciseInputs(exercise)
{
     /*
    Returned Values:
    ExerciseId
    ActivityName
    InputFieldName
    Attribute     
    */
    $.ajax({url:'ajax.php?module=custom',data:{chosenexercise:exercise,encode:'json'},dataType:"json",success:function(json) { 
        var Html = '<div class="ActivityAttributes">';    
        Html += '<form id="activityform" name="activityform">';
        //var i = document.getElementById('rowcounter').value;
        var RoundNo = $('#addround').val();
        var OrderBy = $('#Round' + RoundNo + 'Counter').val();
        var Elements = new Array();   
            $.each(json, function() {
                if(this.UOM == null){
                    UOM = '';
                    UOMId = 0;
                }else{
                    UOM = this.UOM;
                    UOMId = this.UOMId;                   
                }
                if(this.Attribute == 'Distance'){ 
                    Elements.push(''+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_0_'+OrderBy+'');
                    Html += '<div style="float:left;margin:10px 25px 10px 25px"><input placeholder="'+this.Attribute+'" style="width:80px" type="number" id="'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_0_'+OrderBy+'" name="'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_0_'+OrderBy+'"/></div>';
                    Elements.push(''+RoundNo+'_'+this.ExerciseId+'_Distance_UOM');
                    Html += '<div style="float:left;margin:10px 25px 10px 25px"><select id="'+RoundNo+'_'+this.ExerciseId+'_Distance_UOM" name="'+RoundNo+'_'+this.ExerciseId+'_Distance_UOM">';
            if('<?php echo $Display->SystemOfMeasure();?>' == 'Metric'){
                Html += '<option value="2">Metres</option>';
                Html += '<option value="1">Kilometres</option>';
                Html += '</select>';               
            }else{
                Html += '<option value="3">Miles</option>';
                Html += '<option value="4">Yards</option>';
                Html += '</select>';                
            } 
            Html += '</div>';
        }else{
                Elements.push(''+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_'+UOMId+'_'+OrderBy+'');
                Html += '<div style="float:left;margin:10px 25px 10px 25px"><input placeholder="'+this.Attribute+' '+UOM+'" style="width:80px" type="number" id="'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_'+UOMId+'_'+OrderBy+'" name="'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_'+UOMId+'_'+OrderBy+'"/></div>';
               }
            });

            Html += '<div style="float:right;margin:10px 35px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="AddActivity(\''+Elements+'\');" value="Add Activity"/></div>';
            Html += '</div></form><div class="clear"></div>';       

        $('#ExerciseInputs').html(Html);
    }});  
    return false;   
}

function AddActivity(Elements)
{
    var arr = Elements.split(',');
    var Data = '';
    for (var i = 0; i < arr.length; i++) {
        if(i > 0)
            Data += '&';
        Data += arr[i];
        Data += '=';
        Data += $('#'+arr[i]+'').val();
    }

    $.ajax({url:'ajax.php?module=custom&action=formsubmit&thisform=addactivity&'+Data+'',data:"",dataType:"html",success:addactivitydisplay});      
}

function RemoveFromList(ThisItem)
{
    var r=confirm("Remove item?");
    if (r==true)
    {
        var Explode = ThisItem.split('_');
        var RoundNo = Explode[0];
        $('#' + ThisItem + '').remove();
        
        document.getElementById('rowcounter').value--;
        document.getElementById('Round' + RoundNo + 'Counter').value--;

        if($('#Round' + RoundNo + 'Counter').val() == 0){
            chosenexercises = '';
            $('#Round' + RoundNo + 'Label').html('');
        }
    }
}

function Save()
{
    if($('#rowcounter').val() == 0){
        alert('No Exercises selected!');
    }else{
        if($('#timerContainer').hasClass('active')){
            $("#TimeToComplete").val($('#clock').html())
        }else{
            $('#timerContainer').html('');
        }
        $.getJSON('ajax.php?module=custom&action=validateform', $("#customform").serialize(),messagedisplay);
    }
}

function addnew(RoundNo, OrderBy)
{
    $.ajax({url:'ajax.php?module=custom&action=formsubmit&RoundNo='+RoundNo+'&OrderBy='+OrderBy+'',data:$("#customform").serialize(),dataType:"html",success:addactivitydisplay});          
    $.ajax({url:'ajax.php?module=custom',data:{dropdown:'refresh'},dataType:"html",success:dropdownrefresh});  
}

function addRound()
{  
    var RoundCouter = $('#rowcounter').val();
    var PrevRoundNo = $('#addround').val();
    var RowNo = $('#rowcounter').val();
    if(RowNo == 0){
        alert('No Exercises selected!');
    }else if($('#Round' + PrevRoundNo + 'Counter').val() == 0){
        alert('No Exercises selected for round ' + PrevRoundNo + '!');
    }else{
        if($('#Round1Label').html() == '')
            $('#Round1Label').html('Round 1');
        document.getElementById('addround').value++;
        var RoundNo = $('#addround').val();
        var ThisRound ='<br/><div class="RoundLabel" id="Round' + RoundNo + 'Label">Round ' + RoundNo + '</div>';
        ThisRound+= '<input type="hidden" name="Round' + RoundNo + 'Counter" id="Round' + RoundNo + 'Counter" value="'+RoundCouter+'"/>';
        ThisRound+=chosenexercises.replace(/RoundNo/g, RoundNo);
        ThisRound=ThisRound.replace(/RowNo/g, RowNo);
        ThisRound=ThisRound.replace(/undefined/g, '');

        $(ThisRound).appendTo($('#activity_list'));
    }

    $('.textinput').textinput();
    $('.numberinput').textinput();
    $('.listview').listview();
    $('.listview').listview('refresh');    
}

function clockSelect(type)
{
    if(type == 'select'){
        type = 'stopwatch';
    if($('#timerContainer').hasClass('active'))
        $('#timerContainer').removeClass('active');
    else    
        $('#timerContainer').addClass('active');
    }
    $('#clockType').val(type)
}

function ShowHideStopwatch()
{
    if($('#timerContainer').hasClass('active')){
        $('#timerContainer').removeClass('active');
    }else{      
        $('#timerContainer').addClass('active');
    }
}

function clockControl()
{
    if($('#clockType').val() == 'timer')
        startstopcountdown();
    else if($('#clockType').val() == 'stopwatch')
        startstop();
    else if($('#clockType').val() == 'tabata')
        alert('tabata');
    else
        alert('First choose Clock Type!');
}

function resetControl()
{
    if($('#clockType').val() == 'timer')
        resetcountdown();
    else if($('#clockType').val() == 'stopwatch')
        reset();
    else if($('#clockType').val() == 'tabata')
        alert('tabata');
    else
        alert('First choose Clock Type!');
}

function UpdateActivity(ActivityId, Attributes)
{
    var AttributesArray = Attributes.split('_');
    for(i=0; i < AttributesArray.length;i++){
        $("#"+ActivityId+"_"+AttributesArray[i]+"_html").html($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
        $("#"+ActivityId+"_"+AttributesArray[i]+"").val($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
    }  
}
</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->MainOutput();?>
</div>