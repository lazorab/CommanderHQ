
<script type='text/javascript'>

	$(function(){
		$('#tabs').tabs();

});

function SelectTimingType(type){
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value;
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

function PublishWod(){
    $.getJSON('ajax.php?module=upload&action=validateform', $("#wodform").serialize(),messagedisplay);
}

function PublishAdvancedWod(){
    $.getJSON('ajax.php?module=upload&action=validateform', $("#advancedform").serialize(),messagedisplay);
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
        $('#exercise_'+routineId+'_'+exerciseId+'_input').html(Html)
}

function AddRoutine(){
    var RoutineNumberAppend = document.getElementById('wRoutineCounter').value;
    document.getElementById('wRoutineCounter').value++;
    var ThisRoutineNumber = document.getElementById('wRoutineCounter').value; 
    var Exercises = '<div id="wRoutine_'+ThisRoutineNumber+'">';
    Exercises+= '<h2>Routine '+ThisRoutineNumber+'</h2>';
    Exercises+='<div id="w_exercises_'+ThisRoutineNumber+'"></div>';

    Exercises+='<textarea name="'+ThisRoutineNumber+'_Notes" rows="4" cols="80" placeholder="Add any notes for routine '+ThisRoutineNumber+'"></textarea>';
    Exercises+='</div>';
    var Html = Exercises.replace(/RoutineNumber/g, ThisRoutineNumber);
    $('div#wRoutine_'+RoutineNumberAppend).after(Html);
}

function AddAdvancedRoutine(){
    var RoutineNumberAppend = document.getElementById('aRoutineCounter').value;
    document.getElementById('aRoutineCounter').value++;
    var ThisRoutineNumber = document.getElementById('aRoutineCounter').value; 
    var Exercises = '<div id="aRoutine_'+ThisRoutineNumber+'">';
    Exercises+= '<h2>Routine '+ThisRoutineNumber+'</h2>';
    Exercises+='<div id="a_exercises_'+ThisRoutineNumber+'"></div>';

    Exercises+='<textarea name="'+ThisRoutineNumber+'_Notes" rows="4" cols="80" placeholder="Add any notes for routine '+ThisRoutineNumber+'"></textarea>';
    Exercises+='</div>';
    var Html = Exercises.replace(/RoutineNumber/g, ThisRoutineNumber);
    $('div#aRoutine_'+RoutineNumberAppend).after(Html);
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
    //$('.textinput').textinput();
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
    //$('.textinput').textinput();
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
    var Html ='<form action="index.php" id="newform" name="newform">';
    Html += '<input class="textinput" type="text" id="NewExercise" name="NewExercise" placeholder="Custom Activity"/>';
    Html += '<input class="textinput" size="7" class="textinput" type="text" id="Acronym" name="Acronym" placeholder="Acronym"/>';
    Html += '<input class="textinput" size="8" type="text" name="mWeight" placeholder="Weight(M)"/>';
    Html += '<input class="textinput" size="8" type="text" name="fWeight" placeholder="Weight(F)"/>';
    Html += '<input class="textinput" size="8" type="text" name="mHeight" placeholder="Height(M)"/>';
    Html += '<input class="textinput" size="8" type="text" name="fHeight" placeholder="Height(F)"/>';
    Html += '<input class="textinput" size="8" type="text" name="Distance" placeholder="Distance"/>';
    Html += '<input class="textinput" size="4" type="text" name="Reps" placeholder="Reps"/>';
    Html += '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnew();"/>';
    Html +='</form>';
    $('#add_exercise').html(Html);
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    //$('.textinput').textinput();
}

function addNewActivityAdvanced()
{
    var Html ='<form action="index.php" id="newform" name="newform">';
    Html += '<input class="textinput" type="text" id="NewExercise" name="NewExercise" placeholder="Custom Activity"/>';
    Html += '<input class="textinput" size="7" class="textinput" type="text" id="Acronym" name="Acronym" placeholder="Acronym"/>';
    Html += '<input class="textinput" size="8" type="text" name="mWeight" placeholder="Weight(M)"/>';
    Html += '<input class="textinput" size="8" type="text" name="fWeight" placeholder="Weight(F)"/>';
    Html += '<input class="textinput" size="8" type="text" name="mHeight" placeholder="Height(M)"/>';
    Html += '<input class="textinput" size="8" type="text" name="fHeight" placeholder="Height(F)"/>';
    Html += '<input class="textinput" size="8" type="text" name="Distance" placeholder="Distance"/>';
    Html += '<input class="textinput" size="4" type="text" name="Reps" placeholder="Reps"/>';
    Html += '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnewAdvanced();"/>';
    Html +='</form>';
    $('#add_advanced_exercise').html(Html);
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    //$('.textinput').textinput();
}

function addnew()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#newform").serialize(),wresult);
}

function addnewAdvanced()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#newform").serialize(),aresult);
}

function addexercise()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#exerciseselect").serialize(),wresult);
}

function addexerciseAdvanced()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#exerciseselect").serialize(),aresult);
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

function Remove(RowId)
{
    $('#row_' + RowId + '').remove();
    document.getElementById('wrowcounter').value--;  
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

function wresult(message)
{
    document.getElementById('wrowcounter').value++;
    var ThisRoutineNumber = $('#wRoutineCounter').val();
    var ThisRowNumber = $('#wrowcounter').val();
    var Html = message.replace(/ThisRow/g, ThisRowNumber);
    Html = Html.replace(/ThisRoutine/g, ThisRoutineNumber);
    var exercises = $('#w_exercises_'+ThisRoutineNumber+'');
    var exerciseid = parseInt(message);
    if (exerciseid == Number.NaN) {
        alert(message);
    }else{
        
        $(Html).appendTo(exercises);
    }  

    $('#add_exercise').html('');
    $('#mWeight').val('');
    $('#fWeight').val('');
    $('#mHeight').val('');
    $('#fHeight').val('');
    $('#Distance').val('');
    $('#Reps').val('');
    $("#exerciseselect option[value='none']").attr("selected","selected");
}

function aresult(message)
{
    document.getElementById('arowcounter').value++;
    var ThisRoutineNumber = $('#aRoutineCounter').val();
    var ThisRowNumber = $('#arowcounter').val();
    var Html = message.replace(/ThisRow/g, ThisRowNumber);
    Html = Html.replace(/ThisRoutine/g, ThisRoutineNumber);
    var exercises = $('#a_exercises_'+ThisRoutineNumber+'');
    var exerciseid = parseInt(message);
    if (exerciseid == Number.NaN) {
        alert(message);
    }else{
        
        $(Html).appendTo(exercises);
    }  

    $('#add_exercise').html('');
    $('#mWeight').val('');
    $('#fWeight').val('');
    $('#mHeight').val('');
    $('#fHeight').val('');
    $('#Distance').val('');
    $('#Reps').val('');
    $("#exerciseselect option[value='none']").attr("selected","selected");
}

function messagedisplay(message)
{
    //var exerciseid = parseInt(message);
    if (message != 'Success') {
        alert(message);
    }else{

        alert('Successfully Added');
    }  
}

function dropdownrefresh(data)
{
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value;  
    $('#Routine_'+ThisRoutineNumber).html(data);
}

function addAdvancedRound()
{
    document.getElementById('addAdvancedRound').value++; 
    //$.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
}

function addRound()
{
    document.getElementById('addRound').value++; 
    //$.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
}
</script>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Well rounded WOD</a></li>
        <li><a href="#tabs-2">Advanced WOD</a></li>
    </ul>
    <div id="tabs-1"> 

<div id="add_exercise"></div> 
<input type="button" value="Custom Activity" onClick="addNewActivity();"/>
<?php echo $Display->getExercises('');?>
        
<form action="index.php" id="wodform" name="wodform">
<input type="hidden" name="form" value="submitted"/>
<input type="hidden" name="WodTypeId" value="2"/>
<input type="hidden" name="rowcount" id="wrowcounter" value="0"/>
<input type="hidden" name="RoutineCounter" id="wRoutineCounter" value="1"/>

<p>WOD Name:<input name="WodName" type="text"/> WOD Date:<input class="inputbox-required" type="text" name="WodDate" id="WodDate" maxlength="25" placeholder="Use Calendar" value=""/>
<img src="images/calendar-blue.gif" alt="calendar" id="Start_trigger"/></p>
<script type="text/javascript">
      Calendar.setup({
        inputField : "WodDate",
        trigger    : "Start_trigger",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
</script>
<div id="wRoutine_1">
<h2>Routine 1</h2>
        
<div id="w_exercises_1"></div>       
       
        <textarea name="1_Notes" rows="4" cols="80" placeholder="Add any notes for routine 1"></textarea>
    </div>
        <input type="button" name="add" value="Add Routine" onClick="AddRoutine();"/>
        <input type="button" name="save" value="Save WOD" onClick="PublishWod();"/>
        </form><br/>
    </div>
    
    <div id="tabs-2"> 
        
<div id="add_advanced_exercise"></div>
       
<input type="button" value="Custom Activity" onClick="addNewActivityAdvanced();"/>
<?php echo $Display->getExercises('advanced');?>

<form action="index.php" id="advancedform" name="advancedform">
<input type="hidden" name="form" value="submitted"/>
<input type="hidden" name="WodTypeId" value="4"/>
<input type="hidden" name="rowcount" id="arowcounter" value="0"/>
<input type="hidden" name="RoutineCounter" id="aRoutineCounter" value="1"/>

<p>WOD Name:<input name="WodName" type="text"/> WOD Date:<input class="inputbox-required" type="text" name="WodDate" id="aWodDate" maxlength="25" placeholder="Use Calendar" value=""/>
<img src="images/calendar-blue.gif" alt="calendar" id="aStart_trigger"/></p>
<script type="text/javascript">
      Calendar.setup({
        inputField : "aWodDate",
        trigger    : "aStart_trigger",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
</script>
<div id="aRoutine_1">
<h2>Routine 1</h2>
        
<div id="a_exercises_1"></div>       
       
        <textarea name="1_Notes" rows="4" cols="80" placeholder="Add any notes for routine 1"></textarea>
    </div>
        <input type="button" name="" value="Add Routine" onClick="AddAdvancedRoutine();"/>
        <input type="button" name="" value="Save WOD" onClick="PublishAdvancedWod();"/>
        </form><br/>
    </div>
</div>    

