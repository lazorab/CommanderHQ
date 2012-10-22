<script type='text/javascript'>
var chosenexercises;
function getContent(selection)
{
    $.getJSON("ajax.php?module=custom",{baseline:selection},display);
}

function getCustomExercise(id)
{
    $.getJSON("ajax.php?module=custom",{customexercise:id},display);
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
            resetclock();
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
    $('.select').selectmenu();
    $('.select').selectmenu('refresh');
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('.select').selectmenu();
    $('.select').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
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
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
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
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
    $('.numberinput').textinput();
}

function DisplayExercise(exercise)
{
    $.getJSON("ajax.php?module=custom",{chosenexercise:exercise},function(json) {
    var attributecount = 0;
    $.each(json, function() {attributecount++;});
    var new_exercise = $('#new_exercise');
    var i = document.getElementById('rowcounter').value;
    var j = 0;
    var html = '';
    var Bhtml = '';
    var Chtml = '';
    var ThisRound = '';
    var ThisExercise = '';
    var Unit = '';
    if(i < 1){
        $('#workouttypes').html('<?php echo $Display->WorkoutTypes('none selected');?>');
        $('.select').selectmenu();
        $('.select').selectmenu('refresh');
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

                    html +='</div><div class="row_' + i + '">';
                
           
                html +='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
                html +='<div class="ui-block-a" style="font-size:small">';

                    html += '<input onclick="RemoveFromList(' + i + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="';
                    html +='' + this.InputFieldName + '';
                    html +='"/>';
                
                html +='' + this.InputFieldName + '';
                html += '<div class="clear"></div>';
                html +='</div>';
           }
           	
           if(this.Attribute == 'Distance' || this.Attribute == 'Weight' || this.Attribute == 'Height'){
                Bhtml +='<div class="ui-block-b">';
                Bhtml +='<input class="numberinput" ';		   
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
           
				Bhtml +='type="number" data-inline="true" name="' + this.ExerciseId + '___' + this.Attribute + '[]"';
                Bhtml +=' value=""';
                Bhtml +=' placeholder="Enter ' + this.Attribute + '"/>'+Unit+'';
                Bhtml +='</div>';		
                if(Chtml != ''){
                    html +='' + Bhtml + '' + Chtml + '';
                    Chtml = '';
                    Bhtml = '';
                }
           }
           else if(this.Attribute == 'Reps'){
		        Chtml +='<div class="ui-block-c">';
                Chtml +='<input class="numberinput" ';
				Chtml +='style="width:75%;color:black;font-weight:bold;background-color:#ccff66" ';
				Chtml +='type="number" data-inline="true" name="' + this.ExerciseId + '___' + this.Attribute + '[]"';
                Chtml +=' value=""';
                Chtml +=' placeholder="Enter ' + this.Attribute + '"/>';
                Chtml +='</div>';
                if(Bhtml != ''){
                    html +='' + Bhtml + '' + Chtml + '';
                    Bhtml = '';
                    Chtml = '';
                }
           }
           //}

           j++;
          
           ThisRound = this.RoundNo;
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
        chosenexercises += html;
        $(html).appendTo(new_exercise);
        document.getElementById('rowcounter').value = i; 
        $('.buttongroup').button();
        $('.buttongroup').button('refresh');
    });

        $("#exercise option[value='none']").attr("selected","selected");
    return false;	
}

function RemoveFromList(RowId)
{
    $('.row_' + RowId + '').remove();
    document.getElementById('rowcounter').value--;
	
    if(document.getElementById('rowcounter').value == 0){
     if(document.getElementById('clock_input').html != ''){
        $('#clock_input').html('');
    }       
        $('#workouttypes').html('');
        $('#RoundLabel').html('');
        $('.RoundLabel').html('');
        document.getElementById('addround').value = 1;
        chosenexercises = '';
    }
}

function customsubmit()
{
    $.getJSON('ajax.php?module=custom&action=validateform', $("#customform").serialize(),messagedisplay);
}

function addnew()
{
    $.getJSON('ajax.php?module=custom&action=validateform', $("#customform").serialize(),messagedisplay);
}

function addRound()
{  
    if($('#addround').val() == 1){
        $('#RoundLabel').html('<div class="ui-block-a">Round 1</div><div class="ui-block-b"></div><div class="ui-block-c"></div>');
    }
    document.getElementById('addround').value++; 
    var ThisRound ='<div class="RoundLabel"><div class="ui-block-a">Round ' + document.getElementById('addround').value + '</div><div class="ui-block-b"></div><div class="ui-block-c"></div></div>';
    $(ThisRound).appendTo(new_exercise);
    $(chosenexercises).appendTo(new_exercise);
}

function selecttimer()
{
    $('#clockDisplay').html('<input type="hidden" name="63___CountDown[]" id="CountDown" value=""/><input id="clock" type="text" name="timer" value="" Placeholder="mm:ss"/>');
    document.getElementById('clockType').value = 'timer';
}

function selectstopwatch()
{
    $('#clockDisplay').html('<input type="text" id="clock" name="63___TimeToComplete[]" value="00:00:0" readonly/>');
    document.getElementById('clockType').value = 'stopwatch';
}

function clockControl()
{
    if(document.getElementById('clockType').value == 'timer')
        startstopcountdown();
    else if(document.getElementById('clockType').value == 'stopwatch')
        startstop();
    else
        alert('Timer or Stopwatch?');
}
</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->MainOutput();?>
</div>