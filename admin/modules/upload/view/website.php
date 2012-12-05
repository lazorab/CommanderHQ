<script type='text/javascript'>
function HtmlOutputs(outputType, properties)
{
    if (outputType == "routine")
    {
        var HtmlRoutine = '<?php echo str_replace('\'', '\\\'', $Display->HtmlOutputs('routine')) ?>';
        HtmlRoutine = HtmlRoutine.replace(/unclassified/g, properties.id);
        return HtmlRoutine;
    }
}

function SelectTimingType(type){
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value;
    var Exercises = '<?php echo $Display->getExercises(0);?>';
    var Html = Exercises.replace(/RoutineNumber/g, ThisRoutineNumber);
    $('#new_routine').html(Html);   
    document.getElementById(''+ThisRoutineNumber+'_TimingType').value = type;
}

function addTiming(){
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value;
    var TimingTypes = '<?php echo $Display->TimingTypes();?>';
    var Html = TimingTypes.replace(/RoutineNumber/g, ThisRoutineNumber); 
    $('#AddTiming_'+ThisRoutineNumber).html(Html);  
}

function addComments(){
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value;
    var Notes = '<?php echo $Display->getNotes();?>';
    var Html = Notes.replace(/RoutineNumber/g, ThisRoutineNumber);
    $('#AddNotes_'+ThisRoutineNumber).html(Html);   
}

function Publish(){
    $.getJSON('ajax.php?module=upload&action=validateform', $("#gymform").serialize(),messagedisplay);
}

function getInputFields(routineId, exerciseId){
    var Html='';
    if(document.getElementById('exercise_'+routineId+'_'+exerciseId+'_input').innerHTML == ''){
        $.ajax({url:'ajax.php?module=upload',data:{chosenexercise:exerciseId,encode:'json'},dataType:"json",success:function(json) {
            $.each(json, function() {  
                if(this.Attribute == 'Height')        
                    Html+='<input type="text" name="'+routineId+'_'+exerciseId+'_Height" value="" style="float:left;width:75px" placeholder="Height"/>';
                
                if(this.Attribute == 'Rounds')        
                    Html+='<input type="text" name="'+routineId+'_'+exerciseId+'_Rounds" value="" style="float:left;width:75px" placeholder="Rounds"/>';
                if(this.Attribute == 'Weight'){
                    Html+='<input type="text" name="'+routineId+'_'+exerciseId+'_FWeight" value="" style="float:left;width:75px" placeholder="Weight(F)"/>';
                    Html+='<input type="text" name="'+routineId+'_'+exerciseId+'_MWeight" value="" style="float:left;width:75px" placeholder="Weight(M)"/>';
                }
                if(this.Attribute == 'Reps') 
                    Html+='<input type="text" name="'+routineId+'_'+exerciseId+'_Reps" value="" style="float:left;width:75px" placeholder="Reps"/>';
                if(this.Attribute == 'Distance')        
                    Html+='<input type="text" name="'+routineId+'_'+exerciseId+'_Distance" value="" style="float:left;width:75px" placeholder="Distance"/>';
            });
            $('#exercise_'+routineId+'_'+exerciseId+'_input').html(Html);
        }
        });

    }
    else
        $('#exercise_'+exerciseId+'_input').html(Html)
}

function AddRoutine(){
    var RoutineNumberAppend = document.getElementById('RoutineCounter').value;
    document.getElementById('RoutineCounter').value++;
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value; 
    var Exercises = '<div class="exercises" id="Routine_'+ThisRoutineNumber+'">';
    Exercises+= '<h2>Routine '+ThisRoutineNumber+'</h2>';
    Exercises+='<?php echo $Display->getExercises(0);?>';
    Exercises+='</div>';
    Exercises+='<div id="AddTiming_'+ThisRoutineNumber+'"></div>';
    Exercises+='<div id="AddNotes_'+ThisRoutineNumber+'"></div>';
    var Html = Exercises.replace(/RoutineNumber/g, ThisRoutineNumber);
    $('div#Routine_'+RoutineNumberAppend).after(Html);
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

function _addRoutine(routineOrderId)
{
    $('div.routine').each(function() {
        var idNumber = $(this).attr('id').split("_")[1];
        if (idNumber > routineOrderId)
        {
            $(this).attr('id', 'routine_' + (parseInt(idNumber) + 1));
        }
    });

    var Html = HtmlOutputs('routine', {'id': routineOrderId + 1});
    
    $($("form#routines-form div.routine")[routineOrderId - 1]).after($(Html));
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

function addNewActivity()
{
    var Html ='<br/><input class="textinput" type="text" id="NewExercise" name="NewExercise" value="" placeholder="New Exercise Name"/>';
    Html += '<br/><input class="textinput" type="text" id="Acronym" name="Acronym" value="" placeholder="Acronym for Exercise?"/>';
    Html += '<br/>Applicable Attributes:<br/><br/>';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Weight"/>Weight';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Height"/>Height<br/>';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Distance"/>Distance';
    Html += '<input type="checkbox" name="ExerciseAttributes[]" value="Reps"/>Reps<br/><br/>';
    Html += '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnew();"/><br/><br/>';
    $('#add_exercise').html(Html);
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
}

function addnew()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#gymform").serialize(),messagedisplay);
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
        $('#workouttypes').html('<?php echo $Display->TimingTypes('none selected');?>');
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

function messagedisplay(message)
{ 
    var exerciseid = parseInt(message);
    if (exerciseid == Number.NaN) {
        alert(message);
    }else{
        var ThisRoutineNumber = document.getElementById('RoutineCounter').value;
        $.ajax({url:'ajax.php?module=upload',data:{dropdown:'refresh',newexercise:exerciseid,routineno:ThisRoutineNumber},dataType:"html",success:dropdownrefresh});  
        $('#add_exercise').html('');
        alert('Successfully Added');
    }  
}

function dropdownrefresh(data)
{
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value;  
    $('#Routine_'+ThisRoutineNumber).html(data);
}

function addRound()
{
    document.getElementById('addround').value++; 
    //$.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
}
</script>

<br />
<div class="actionbutton"><a href="#" onClick="addNewActivity();"><img alt="Add Activity" src="images/AddActivity.png"/></a></div>
<div class="actionbutton"><a href="#" onClick="addTiming();"><img alt="Add Timing" src="images/AddTiming.png"/></a></div>
<div class="actionbutton"><a href="#" onClick="addComments();"><img alt="Add Comments" src="images/AddComments.png"/></a></div>
<div class="clear"></div>
<br />
<form action="index.php" id="gymform" name="form">
<input type="hidden" name="form" value="submitted"/>
<input type="hidden" name="rowcount" id="rowcounter" value="0"/>
<input type="hidden" name="RoutineCounter" id="RoutineCounter" value="1"/>
<div id="add_exercise"></div>
<p>WOD Date:<input class="inputbox-required" type="text" name="WodDate" id="WodDate" maxlength="25" placeholder="Use Calendar" value=""/>
<img src="images/calendar-blue.gif" alt="calendar" id="Start_trigger"/></p>
<script type="text/javascript">
      Calendar.setup({
        inputField : "WodDate",
        trigger    : "Start_trigger",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
</script> 
<div id="AjaxOutput">  
    <?php echo $Display->Output();?>
</div>
<div style="width:125px;float:right">
<input type="button" onClick="Publish();" name="" value="Publish"/>
<input type="button" onClick="AddRoutine()" name="" value="+"/>
</div>
<div class="clear"></div>
<br/>

<div class="ui-grid-b">
<div id="display_benchmark"></div>
<div id="new_routine"></div>
</div>
</form><br/>
