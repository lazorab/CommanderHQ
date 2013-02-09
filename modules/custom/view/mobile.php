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
    //$.getJSON("ajax.php?module=custom",{baseline:selection},display);
}

function getCustomExercise(id)
{
    $.ajax({url:'ajax.php?module=custom',data:{customexercise:id},dataType:"html",success:display});  
    //$.getJSON("ajax.php?module=custom",{customexercise:id},display);
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
        $.getJSON("ajax.php?module=custom",{dropdown:'refresh'},dropdownrefresh);
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

function addTypeParams(CustomType)
{
    var Html='';
    
        if(CustomType == 'Total Reps'){
            Html +='<input type="number" name="Reps" value="" placeholder="Total Reps"/>';
            Html+='<?php echo $Display->getStopWatch();?>';
            Html+='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';
        }
        else if(CustomType == 'AMRAP Rounds'){
        $('#RoundLabel').html('<div class="ui-block-a">Round 1</div><div class="ui-block-b"></div><div class="ui-block-c"></div>');
        Html+='<?php echo $Display->getRoundCounter();?>';
	Html+='<input type="hidden" name="63___CountDown[]" id="CountDown" value=""/>';
        Html+='<input id="clock" type="text" name="timer" value="" placeholder="mm:ss"/>';
        Html+='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="Start"/>';
        Html+='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
        Html+='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';
        }  
        else if(CustomType == 'AMRAP Reps'){
	Html+='<input type="hidden" name="63___CountDown[]" id="CountDown" value=""/>';
        Html+='<input id="clock" type="text" name="timer" value="" placeholder="mm:ss"/>';
        Html+='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="Start"/>';
        Html+='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
        Html+='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';
        }
         else if(CustomType == 'EMOM'){
	Html+='<input type="hidden" name="63___CountDown[]" id="CountDown" value=""/>';
        Html+='<input id="clock" type="text" name="timer" value="" placeholder="mm:ss"/>';
        Html+='<input id="startstopbutton" class="buttongroup" type="button" onClick="startstopcountdown();" value="Start"/>';
        Html+='<input id="resetbutton" class="buttongroup" type="button" onClick="resetcountdown();" value="Reset"/>';
        Html+='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';
        }       
        else if(CustomType == 'Timed'){
            Html+='<?php echo $Display->getStopWatch();?>';
            Html+='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>';
        }
        
        if(Html != ''){
    $('#clock_input').html(Html);

    $('#addround').textinput();
    }
}

function SelectionControl(exercise)
{
    $('#add_exercise').html('');
    if(exercise == 'Add New')
        addNewExercise();
    else
        DisplayExercise(exercise);
}

function addNewExercise()
{
    var Html ='<br/><input class="textinput" type="text" id="NewExercise" name="NewExercise" value="" placeholder="New Exercise Name"/>';
    Html += '<br/><input class="textinput" type="text" id="Acronym" name="Acronym" value="" placeholder="Acronym for Exercise?"/>';
    Html += '<br/>Applicable Attributes:<br/><br/>';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Weight"/>Weight';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Height"/>Height<br/>';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Distance"/>Distance';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Reps"/>Reps<br/><br/>';
    Html += '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnew();"/>';
    $('#add_exercise').html(Html);

    $('.textinput').textinput();
    $('.numberinput').textinput();
}

function DisplayExercise(exercise)
{
    //$.getJSON("ajax.php?module=custom",{chosenexercise:exercise},function(json) {
    $.ajax({url:'ajax.php?module=custom',data:{chosenexercise:exercise,encode:'json'},dataType:"json",success:function(json) { 

    var attributecount = 0;
    $.each(json, function() {attributecount++;});
    var new_exercise = $('#new_exercise');
    var i = document.getElementById('rowcounter').value;
    var RoundNo = document.getElementById('addround').value;
    var j = 0;
    var html = '';
    var Bhtml = '';
    var Chtml = '';
    var ThisExercise = '';
    var Unit = '';
    if($('#addround').val() == 1){
        $('#Round1Label').html('<div class="ui-block-a"></div><div class="ui-block-b" style="text-align:center">Round 1</div><div class="ui-block-c"></div>');
    }

    $.each(json, function() {

           if(ThisExercise != this.ActivityName){

                if(Chtml != '' && Bhtml == ''){
                    html +='<div class="ui-block-b"></div>' + Chtml + '';
                    Chtml = '';
                    Bhtml = '';
                }
                if(Chtml == '' && Bhtml != ''){
                    html +='' + Bhtml + '<div class="ui-block-c"></div>';
                    Chtml = '';
                    Bhtml = '';
                }
           
                i++;
                document.getElementById('Round' + RoundNo + 'Counter').value++;
                
                html +='</div><div id="row_' + i + '">';
                html +='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
                html +='<div class="ui-block-a" style="font-size:small">';

                //html+='<input class="buttongroup" data-icon="delete" name="exercise_' + i + '" type="button" onClick="RemoveFromList(' + i + ')" value="';
                //html += '<input onclick="RemoveFromList(' + i + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="/>';
                html +='<input id="' + this.InputFieldName + '" onclick="RemoveFromList(' + i + ', ' + RoundNo + ')" class="textinput" data-inline="true" type="text" style="width:75%;" name="" value="' + this.InputFieldName + '"/>';
                  //  html +='"/>';
                //html += '<div class="swipeleft">' + this.InputFieldName + '</div>';
                //html +='' + this.InputFieldName + '';
                html += '<div class="clear"></div>';
                html +='</div>';
           }
           	
           if(this.Attribute == 'Distance' || this.Attribute == 'Weight' || this.Attribute == 'Height'){
                Bhtml +='<div class="ui-block-b">';
                Bhtml +='<input data-corners="false" class="numberinput" ';		   
                if(this.Attribute == 'Distance'){
                    Bhtml +='style="width:75%;color:white;font-weight:bold;background-color:#6f747a" ';
                    if('<?php echo $Display->SystemOfMeasure();?>' == 'imperial')
                        Unit = 'yards';
                    else
                        Unit = 'metres';
                }		
                else if(this.Attribute == 'Weight'){
					Bhtml +='style="width:75%;color:white;font-weight:bold;background-color:#3f2b44" ';
                    if('<?php $Display->SystemOfMeasure();?>' == 'imperial')
                        Unit = 'lbs';
                    else
                        Unit = 'kg';
                }
                else if(this.Attribute == 'Height'){
                    Bhtml +='style="width:75%;color:white;font-weight:bold;background-color:#66486e" ';
                    if('<?php $Display->SystemOfMeasure();?>' == 'imperial')
                        Unit = 'inches';
                    else
                        Unit = 'cm';
                }				
           
                Bhtml +='type="number" data-inline="true" name="' + RoundNo + '___' + this.ExerciseId + '___' + this.Attribute + '"';
                Bhtml +=' value=""';
                Bhtml +=' placeholder="' + this.Attribute + '"/>'+Unit+'';
                Bhtml +='</div>';		
                if(Chtml != ''){
                    html +='' + Bhtml + '' + Chtml + '';
                    Chtml = '';
                    Bhtml = '';
                }
           }
           else if(this.Attribute == 'Reps'){
		Chtml +='<div class="ui-block-c">';
                Chtml +='<input data-corners="false" class="numberinput" ';
		Chtml +='style="width:75%;color:black;font-weight:bold;background-color:#ccff66" ';
		Chtml +='type="number" data-inline="true" name="'+ RoundNo + '___' + this.ExerciseId + '___' + this.Attribute + '"';
                Chtml +=' value=""';
                Chtml +=' placeholder="' + this.Attribute + '"/>';
                Chtml +='</div>';
                if(Bhtml != ''){
                    html +='' + Bhtml + '' + Chtml + '';
                    Bhtml = '';
                    Chtml = '';
                }
           }
           //}

           j++;
          
           ThisExercise = this.ActivityName;           
        }); 
     
        if(Chtml != '' && Bhtml == ''){
           html+='<div class="ui-block-b"></div>' + Chtml + '';
           Chtml = '';
           Bhtml = '';
        }
        if(Chtml == '' && Bhtml != ''){
           html+='' + Bhtml + '<div class="ui-block-c"></div>';
           Chtml = '';
           Bhtml = '';
        }
        html +='</div>';
        //alert(html);
        //chosenexercises += html;
        $(html).appendTo(new_exercise);
        document.getElementById('rowcounter').value = i; 

        $('.textinput').textinput();
        $('.numberinput').textinput();
        $("#exercise option[value='none']").attr("selected","selected");
    }}); 
        
    $("#exercise option[value='none']").attr("selected","selected");
    return false;	       
}

function RemoveFromList(RowId,RoundNo)
{
    var r=confirm("Remove item?");
    if (r==true)
    {
    $('#row_' + RowId + '').remove();
    document.getElementById('rowcounter').value--;
    document.getElementById('Round' + RoundNo + 'Counter').value--;

    if(document.getElementById('Round' + RoundNo + 'Counter').value == 0){
        $('#Round' + RoundNo + 'Label').html('');
    }

    if(document.getElementById('rowcounter').value == 0){
        //$('#new_exercise').html('');
        $('#Round1Label').html('');
        $('.RoundLabel').html('');
        $('#controls').html('');
        document.getElementById('addround').value = 1;
        //chosenexercises = '';
    }
    }
}

function Save()
{
    if(document.getElementById('rowcounter').value == 0){
        alert('No Exercises selected!');
    }else{
    $.getJSON('ajax.php?module=custom&action=validateform', $("#customform").serialize(),messagedisplay);
    }
}

function addnew()
{
    $.getJSON('ajax.php?module=custom&action=validateform', $("#customform").serialize(),messagedisplay);
}

function addRound()
{  
    var PrevRoundNo = document.getElementById('addround').value;
    if(document.getElementById('rowcounter').value == 0){
        alert('No Exercises selected!');
    }else if(document.getElementById('Round' + PrevRoundNo + 'Counter').value == 0){
        alert('No Exercises selected for round ' + PrevRoundNo + '!');
    }else{

    document.getElementById('addround').value++;
    var RoundNo = document.getElementById('addround').value;
    var ThisRound ='<div class="RoundLabel" id="Round' + RoundNo + 'Label"><div class="ui-block-a"></div><div class="ui-block-b" style="text-align:center"><br/>Round ' + RoundNo + '</div><div class="ui-block-c"></div></div>';
    ThisRound+='<input type="hidden" name="Round' + RoundNo + 'Counter" id="Round' + RoundNo + 'Counter" value="0"/>';
    $(ThisRound).appendTo(new_exercise);
    //$(chosenexercises).appendTo(new_exercise);
}

    $('.textinput').textinput();
    $('.numberinput').textinput();
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
    document.getElementById('clockType').value = type;
}

function clockControl()
{
    if(document.getElementById('clockType').value == 'timer')
        startstopcountdown();
    else if(document.getElementById('clockType').value == 'stopwatch')
        startstop();
    else if(document.getElementById('clockType').value == 'tabata')
        alert('tabata');
    else
        alert('First choose Clock Type!');
}

function resetControl()
{
    if(document.getElementById('clockType').value == 'timer')
        resetcountdown();
    else if(document.getElementById('clockType').value == 'stopwatch')
        reset();
    else if(document.getElementById('clockType').value == 'tabata')
        alert('tabata');
    else
        alert('First choose Clock Type!');
}


</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->MainOutput();?>
</div>