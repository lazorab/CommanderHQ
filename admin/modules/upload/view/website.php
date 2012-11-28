<script type='text/javascript'>
function HtmlOutputs(outputType, properties)
{
    if (outputType == "routine")
    {
        var HtmlRoutine = '';
        HtmlRoutine+='<div class="routine" id="routine_' + properties.id + '">';
        HtmlRoutine+='<input name="routine_name_' + properties.id + '" type="text" value="Name of routine"/>';
        HtmlRoutine+='<br/>';
        HtmlRoutine+='<div>';
        HtmlRoutine+='<a onclick="addRoutine(' + properties.id + ')" href="#" class="add_routine">+</a>';
        return HtmlRoutine;
    }
}


function getContent(selection)
{
    $.getJSON("ajax.php?module=upload",{baseline:selection},display);
}

function getCustomExercise(id)
{
    $.getJSON("ajax.php?module=upload",{customexercise:id},display);
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
}

function addRoutine(id)
{
    var Html = HtmlOutputs('routine', {'id': id + 1});
    
    $($("form#routines-form div.routine")[id - 1]).after($(Html));
}

function addTypeParams(CustomType)
{
    var Html='';
  
        if(CustomType == 'Total Reps'){
            Html +='<input type="number" name="Reps" value="" placeholder="Total Reps"/>';
        }
        if(CustomType == 'Total Rounds'){
            Html+='<div class="ui-grid-a">';
            Html+='<div class="ui-block-a"><input class="buttongroup" data-inline="true" type="button" onclick="addRound();" value="+ Round"/></div>';
            Html+='<div class="ui-block-b"><input style="width:75%" id="addround" data-inline="true" type="number" name="0___66___Rounds" value="0"/></div>';
            Html+='</div>';
        }  
        
        Html+='<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="uploadsubmit();"/>';
        
    $('#clock_input').html(Html);
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('#addround').textinput();
    $('.textinput').textinput();
}

function SelectionControl(type,id)
{

    $('#add_exercise').html('');
    if(id == 0)
        addNewExercise();
    else if(type=='activity')
        DisplayExercise(id);
    else if(type=='benchmark')
        DisplayBenchmark(id);
}

function addNewExercise()
{
    var Html ='<input class="textinput" type="text" id="NewExercise" name="NewExercise" value="" placeholder="New Exercise Name"/>';
    Html += '<br/>Applicable Attributes:<br/><br/>';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Weight"/>Weight';
    Html += ' <input type="checkbox" name="ExerciseAttributes[]" value="Height"/>Height<br/>';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Distance"/>Distance';
    Html += ' <input type="checkbox" name="ExerciseAttributes[]" value="Reps"/>Reps<br/><br/>';
    Html += '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnew();"/>';
    $('#add_exercise').html(Html);
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
}

function DisplayBenchmark(id)
{
    $("#exercise option[value='none']").attr("selected","selected");
    $('#workouttypes').html('');
    $('#add_exercise').html('');
    $('#new_exercise').html('');
    $('#clock_input').html('');
    
    document.getElementById('rowcounter').value = 0;
    
    $.getJSON("ajax.php?module=upload",{benchmarkid:id},function(j) {
        $('#wodname').val('' + j.WorkoutName + '');
        var html = '';
        html +='<input class="benchmark_' + j.recid + '" type="hidden" name="benchmarkId" value="' + j.recid + '"/>';
        html += '<div class="benchmark_' + j.recid + '">';
        html += '<input onclick="RemoveFromList(\'benchmark\')" type="checkbox" name="benchmark_' + j.recid + '" checked="checked" value="' + j.WorkoutName + '"/>'; 
        html +='' + j.WorkoutName + '</div>';  
        $('#display_benchmark').html(html);
    }); 
    $('#btnsubmit').html('<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="uploadsubmit();"/>');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
}

function DisplayExercise(id)
{
    $('#btnsubmit').html('');
    $("#benchmark option[value='none']").attr("selected","selected");
    $('#display_benchmark').html('');
    $.getJSON("ajax.php?module=upload",{activityid:id},function(json) {
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

           //not sure about this...so 1==2 disables it
           
           if(1==2 && ThisRound != this.RoundNo){
           
                if(Chtml != '' && Bhtml == ''){
                    html +='<div class="ui-block-b"></div>' + Chtml + '';
                    Chtml = '';
                    Bhtml = '';
                }
                if(Chtml == '' && Bhtml != ''){
                    html += '' + Bhtml + '<div class="ui-block-c"></div>';
                    Chtml = '';
                    Bhtml = '';
                }
            
                i++; 
                if(j == 0){
                    html +='<div id="row_' + i + '">';
                }
                else{
                    html +='</div><div id="row_' + i + '">';
                }               
           
                html +='<div class="ui-block-a"></div><div class="ui-block-b">Round ' + this.RoundNo + '</div><div class="ui-block-c"></div>';
             
                html +='<div class="ui-block-a" style="font-size:small">';
 
                    html += '<input onclick="RemoveFromList(' + i + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="';
                    html +='' + this.ActivityName + '';
                    html +='"/>';
                
                html +='' + this.ActivityName + '';
                html += '<div class="clear"></div>';
                html +='</div>';
           
           }
           else if(ThisExercise != this.ActivityName){

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
                if(j == 0){
                    html +='<div id="row_' + i + '">';
                }
                else{
                    html +='</div><div id="row_' + i + '">';
                }
           
                html +='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
                html +='<div class="ui-block-a" style="font-size:small">';

                    html += '<input onclick="RemoveFromList(' + i + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="';
                    html +='' + this.ActivityName + '';
                    html +='"/>';
                
                html +='' + this.ActivityName + '';
                html += '<div class="clear"></div>';
                html +='</div>';
           }
           	
           if(this.Attribute == 'Distance' || this.Attribute == 'Weight' || this.Attribute == 'Height'){
                Bhtml +='<div class="ui-block-b">';
                Bhtml +='<input class="textinput" ';		   
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
           
				Bhtml +='type="number" data-inline="true" name="' + this.RoundNo + '___' + this.recid + '___' + this.Attribute + '"';
                Bhtml +=' value="' + this.AttributeValue + '"';
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
                Chtml +='<input class="textinput" ';
				Chtml +='style="width:75%;color:black;font-weight:bold;background-color:#ccff66" ';
				Chtml +='type="number" data-inline="true" name="' + this.RoundNo + '___' + this.recid + '___' + this.Attribute + '"';
                Chtml +=' value="' + this.AttributeValue + '"';
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
    if(RowId == 'benchmark'){
        $('#display_benchmark').html('');
    }
    else if(RowId > 0){
        $('#row_' + RowId + '').remove();
	document.getElementById('rowcounter').value--;
    }
		
    if(document.getElementById('clock_input').html != ''){
        $('#clock_input').html('');
    }
	
    if(document.getElementById('rowcounter').value == 0){
        $("#exercise option[value='none']").attr("selected","selected");
        $('#btnsubmit').html('');
    }
}

function uploadsubmit()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#uploadform").serialize(),messagedisplay);
}

function addnew()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#uploadform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    if(message == 'Exercise Successfully Added!'){
        $("#exercise option[value='none']").attr("selected","selected");
        $('#add_exercise').html('');
    }   
    else{
         alert(message); 

    }  
}

function addnew()
{
    var NewExercise = document.getElementById('NewExercise').value;
    $.getJSON('ajax.php?module=upload', {newexercise:NewExercise},display);
}

function addRound()
{
    document.getElementById('addround').value++; 
    //$.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
}
</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->Output();?>
</div>
