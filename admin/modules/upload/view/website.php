
<script type='text/javascript'>

	$(function(){
		$('#tabs').tabs();

});

//****************************************************Well Rounded WOD**********************************************************
var LastActivity = '';
var DuplicateRound;
var DuplicateRoutine;

function PublishWod(){
    $.getJSON('ajax.php?module=upload&action=validateform', $("#wodform").serialize(),messagedisplay);
}

function getInputFields(exerciseId){
    $.getJSON('ajax.php?module=upload&action=getInputFields', {ExerciseId:exerciseId},inputdisplay);
}

function inputdisplay(data){
    var routine = document.getElementById('RoutineCounter').value;
    var Html = data.replace(/ThisRoutine/g, routine);
    $('#inputs').html(Html);
}

function AddRoutine(){
    DuplicateRound = '';
    var PrevRoutineNo = $('#RoutineCounter').val();
    var RowNo = $('#rowcounter').val();
    if(RowNo == 0){
        alert('Routine empty!');
    }else if($('#Routine' + PrevRoutineNo + 'Counter').val() == 0){
        alert('No Exercises selected for routine ' + PrevRoutineNo + '!');
    }else{
        if($('#Routine1Label').html() == '')
            $('#Routine1Label').html('Routine 1');
        document.getElementById('RoutineCounter').value++;
        var RoutineNo = $('#RoutineCounter').val();
        var ThisRoutine ='<br/><div class="RoutineLabel" id="Routine' + RoutineNo + 'Label">Routine ' + RoutineNo + '</div>';
        ThisRoutine += '<div class="RoundLabel" id="Routine' + RoutineNo + 'Round1Label"></div>';
        ThisRoutine += '<input type="hidden" name="Routine' + RoutineNo + 'Counter" id="Routine' + RoutineNo + 'Counter" value="0"/>';
        ThisRoutine += '<input type="hidden" name="Routine' + RoutineNo + 'RoundCounter" id="Routine' + RoutineNo + 'RoundCounter" value="1"/>';               
        ThisRoutine += '<div id="activity'+RoutineNo+'list"></div>';

        $(ThisRoutine).appendTo($('#Routines'));
    }
}

function AddRound()
{
    var RoutineNo = $('#RoutineCounter').val();
    var PrevRoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();
    var RowNo = $('#rowcounter').val();
    document.getElementById('Routine' + RoutineNo + 'RoundCounter').value++;
    var RoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();   
    if(RowNo == 0){
        alert('No Exercises selected!');
    }else if($('#Round' + PrevRoundNo + 'Counter').val() == 0){
        alert('No Exercises selected for round ' + PrevRoundNo + '!');
    }else{
        if($('#Routine' + RoutineNo + 'Round1Label').html() == '')
            $('#Routine' + RoutineNo + 'Round1Label').html('Round 1');

        var ThisRound ='<br/><div class="RoundLabel" id="Routine' + RoutineNo + 'Round' + RoundNo + 'Label">Round ' + RoundNo + '</div>';
        ThisRound+= '<input type="hidden" name="Round' + RoundNo + 'Counter" id="Round' + RoundNo + 'Counter" value="'+RowNo+'"/>';
        
        ThisRound+=DuplicateRound.replace(/RoundNo/g, RoundNo);
        ThisRound=ThisRound.replace(/ThisRow/g, RowNo);
        ThisRound=ThisRound.replace(/undefined/g, '');

        $(ThisRound).appendTo($('#activity'+RoutineNo+'list'));        
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
    //$('.textinput').textinput();
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

function CancelAddNew(){
    $('#add_exercise').html('');
    $('#select_exercise').removeClass('inactive');
}

function addNewActivity()
{
    $('#select_exercise').addClass('inactive');
    var Html ='<form action="index.php" id="newform" name="newform">';
    Html += '<input class="textinput" type="text" id="NewExercise" name="NewExercise" placeholder="Custom Activity"/>';
    Html += '<input size="7" class="textinput" type="text" id="Acronym" name="Acronym" placeholder="Acronym"/>';
    Html += '<input type="checkbox" name="attributes[]" value="Weight"/>Weight';
    Html += '<input type="checkbox" name="attributes[]" value="Height"/>Height';
    Html += '<input type="checkbox" name="attributes[]" value="Distance"/>Distance';
    Html += '<input type="checkbox" name="attributes[]" value="Reps"/>Reps';
    Html += '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnew();"/>';
    Html += '<input type="button" value="Cancel" onClick="CancelAddNew();"/>';
    Html +='</form><br/>';
    $('#add_exercise').html(Html);
    //$('.buttongroup').button();
    //$('.buttongroup').button('refresh');
    //$('.textinput').textinput();
}

function addnew()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#newform").serialize(),wresult);
}

function AddBenchmark(Id)
{
    $.getJSON('ajax.php?module=upload&action=validateform',{benchmarkId:Id},DisplayBenchmark); 
}

function DisplayBenchmark(data)
{
    var ThisRoutineNumber = $('#RoutineCounter').val(); 
    document.getElementById('rowcounter').value++;
    document.getElementById('Routine' + ThisRoutineNumber + 'Counter').value++; 
    var exercises = $('#activity'+ThisRoutineNumber+'list');
    Html = data.replace(/ThisRoutine/g, ThisRoutineNumber);   
    $(Html).appendTo(exercises);
    $("#benchmark option[value='none']").attr("selected","selected");   
}

function addexercise()
{
    var exercise = $('#Exercise').val();
    var MWeight = $('#mWeight').val();
    var FWeight = $('#fWeight').val();
    var Wuom = $('#WUOM').val();
    var MHeight = $('#mHeight').val();
    var FHeight = $('#fHeight').val();
    var Huom = $('#HUOM').val();
    var dist = $('#Distance').val();
    var Duom = $('#DUOM').val();
    var reps = $('#Reps').val();
    
    if(MWeight == '')
        MWeight = 'Max';
    if(FWeight == '')
        FWeight = 'Max';
    if(Wuom == '')
        Wuom = 'Max';    
    if(FHeight == '')
        FHeight = 'Max';
    if(MHeight == '')
        MHeight = 'Max';
    if(Huom == '')
        Huom = 'Max';
    if(dist == '')
        dist = 'Max';
    if(Duom == '')
        Duom = 'Max';   
    if(reps == '')
        reps = 'Max';   
   
    $.getJSON('ajax.php?module=upload&action=validateform', {Exercise:exercise, mWeight:MWeight, fWeight:FWeight, WUOM:Wuom, fHeight:FHeight, HUOM:Huom, mHeight:MHeight, Distance:dist, DUOM:Duom, Reps:reps},wresult);
}

function Remove(RowId)
{
    var RoutineNo = $('#RoutineCounter').val();
    $('#row_' + RowId + '').remove();
    document.getElementById('rowcounter').value--;  
    document.getElementById('Routine' + RoutineNo + 'Counter').value--; 
	
    if(document.getElementById('rowcounter').value == 0){
        $('#Routine' + RoutineNo + 'Label').html(''); 
    }
        var ThisRoutineRows = $('#Routine' + RoutineNo + 'Counter').val();
        if(ThisRoutineRows == 0 || $('#activity'+RoutineNo+'list').html() == '')
            $('#Routine' + RoutineNo + 'Label').html('');    
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
	alert(document.getElementById('rowcounter').value);
    if(document.getElementById('rowcounter').value == 0){
        $("#exercise option[value='none']").attr("selected","selected");
        $('#btnsubmit').html('');
    }
        var RoutineNo = $('#RoutineCounter').val();
        var ThisRoutineRows = $('#Routine' + RoutineNo + 'Counter').val();
        if(ThisRoutineRows == 0)
            $('#Routine' + RoutineNo + 'Label').html('');   
}

function wresult(message)
{
    if($('#select_exercise').hasClass('inactive'))
        $('#select_exercise').removeClass('inactive');
    if(message == 1){
        alert('Must Enter Exercise Name!');
    }else if(message == 2){
        alert('Must Have at least one Attribute!');
    }else if(message == 3){
        alert('Must Select Exercise!');
    }else if(message == 4){
        alert('Can\'t have distance and height!');
    }else{
    document.getElementById('rowcounter').value++; 
    var ThisRoutineNumber = $('#RoutineCounter').val();
    document.getElementById('Routine' + ThisRoutineNumber + 'Counter').value++;
    var ThisRowNumber = $('#rowcounter').val();
    var ThisRound = $('#Routine' + ThisRoutineNumber + 'RoundCounter').val();
    
    var Html = message.replace(/ThisRoutine/g, ThisRoutineNumber);
    if(ThisRoutineNumber == 1)
        DuplicateRound += Html;
    Html = Html.replace(/ThisRow/g, ThisRowNumber);
    Html = Html.replace(/RoundNo/g, ThisRound);
    
    //alert(Html);
    var exercises = $('#activity'+ThisRoutineNumber+'list');
    $(Html).appendTo(exercises);

    $('#add_exercise').html('');
    $('#mWeight').val('');
    $('#fWeight').val('');
    $('#mHeight').val('');
    $('#fHeight').val('');
    $('#Distance').val('');
    $('#Reps').val('');
    $('#inputs').html('');
    $("#Exercise option[value='none']").attr("selected","selected");
    }
}

function messagedisplay(message)
{
    //var exerciseid = parseInt(message);
    if (message != 'Success') {
        alert(message);
    }else{
        alert('Successfully Saved');
    }  
}

function dropdownrefresh(data)
{
    var ThisRoutineNumber = document.getElementById('RoutineCounter').value;  
    $('#Routine_'+ThisRoutineNumber).html(data);
}

//*************************************************Advanced WOD*******************************************************************

function PublishAdvancedWod(){
    $.getJSON('ajax.php?module=upload&action=validateform', $("#advancedform").serialize(),messagedisplay);
}

function getAdvancedInputFields(exerciseId){
    $.getJSON('ajax.php?module=upload&action=getAdvancedInputFields', {ExerciseId:exerciseId},ainputdisplay);
}

function ainputdisplay(data){
    var routine = document.getElementById('aRoutineCounter').value;
    var Html = data.replace(/ThisRoutine/g, routine);
    $('#ainputs').html(Html);   
}

function AddAdvancedRoutine(){
    DuplicateRound = '';
    var PrevRoutineNo = $('#aRoutineCounter').val();
    var RowNo = $('#arowcounter').val();
    if(RowNo == 0){
        alert('Routine empty!');
    }else if($('a#Routine' + PrevRoutineNo + 'Counter').val() == 0){
        alert('No Exercises selected for routine ' + PrevRoutineNo + '!');
    }else{
        if($('#aRoutine1Label').html() == '')
            $('#aRoutine1Label').html('Routine 1');
        document.getElementById('aRoutineCounter').value++;
        var RoutineNo = $('#aRoutineCounter').val();
        var ThisRoutine ='<br/><div class="RoutineLabel" id="aRoutine' + RoutineNo + 'Label">Routine ' + RoutineNo + '</div>';
        ThisRoutine += '<div class="RoundLabel" id="aRoutine' + RoutineNo + 'Round1Label"></div>';
        ThisRoutine += '<input type="hidden" name="Routine' + RoutineNo + 'Counter" id="aRoutine' + RoutineNo + 'Counter" value="0"/>';
        ThisRoutine += '<input type="hidden" name="Routine' + RoutineNo + 'RoundCounter" id="aRoutine' + RoutineNo + 'RoundCounter" value="1"/>';       
        ThisRoutine += '<div id="aactivity'+RoutineNo+'list"></div>';

        $(ThisRoutine).appendTo($('#aRoutines'));
    }   
}

function AddAdvancedRound()
{
    var RoutineNo = $('#aRoutineCounter').val();
    var PrevRoundNo = $('#aRoutine' + RoutineNo + 'RoundCounter').val();
    var RowNo = $('#arowcounter').val();
    document.getElementById('aRoutine' + RoutineNo + 'RoundCounter').value++;
    var RoundNo = $('#aRoutine' + RoutineNo + 'RoundCounter').val();   
    if(RowNo == 0){
        alert('No Exercises selected!');
    }else if($('#aRound' + PrevRoundNo + 'Counter').val() == 0){
        alert('No Exercises selected for round ' + PrevRoundNo + '!');
    }else{
        if($('#aRoutine' + RoutineNo + 'Round1Label').html() == '')
            $('#aRoutine' + RoutineNo + 'Round1Label').html('Round 1');

        var ThisRound ='<br/><div class="RoundLabel" id="aRoutine' + RoutineNo + 'Round' + RoundNo + 'Label">Round ' + RoundNo + '</div>';
        ThisRound+= '<input type="hidden" name="Round' + RoundNo + 'Counter" id="aRound' + RoundNo + 'Counter" value="'+RowNo+'"/>';
        
        ThisRound+=DuplicateRound.replace(/RoundNo/g, RoundNo);
        ThisRound=ThisRound.replace(/ThisRow/g, RowNo);
        ThisRound=ThisRound.replace(/undefined/g, '');

        $(ThisRound).appendTo($('#aactivity'+RoutineNo+'list'));        
    }    
}

function AddBenchmarkAdvanced(Id)
{
    $.getJSON('ajax.php?module=upload&action=validateform',{benchmarkId:Id},DisplayBenchmarkAdvanced); 
}

function DisplayBenchmarkAdvanced(data)
{
    var ThisRoutineNumber = $('#aRoutineCounter').val(); 
    document.getElementById('arowcounter').value++;
    document.getElementById('aRoutine' + ThisRoutineNumber + 'Counter').value++; 
    var exercises = $('#aactivity'+ThisRoutineNumber+'list');
    Html = data.replace(/ThisRoutine/g, ThisRoutineNumber);   
    $(Html).appendTo(exercises);
    $("#abenchmark option[value='none']").attr("selected","selected");   
}

function addexerciseAdvanced()
{
    var exercise = $('#aExercise').val();
    var MWeight = $('#amWeight').val();
    var FWeight = $('#afWeight').val();
    var Wuom = $('#aWUOM').val();
    var MHeight = $('#amHeight').val();
    var FHeight = $('#afHeight').val();
    var Huom = $('#aHUOM').val();
    var dist = $('#aDistance').val();
    var Duom = $('#aDUOM').val();
    var reps = $('#aReps').val();
    
    if(MWeight == '')
        MWeight = 'Max';
    if(FWeight == '')
        FWeight = 'Max';
    if(Wuom == '')
        Wuom = 'Max';    
    if(FHeight == '')
        FHeight = 'Max';
    if(MHeight == '')
        MHeight = 'Max';
    if(Huom == '')
        Huom = 'Max';
    if(dist == '')
        dist = 'Max';
    if(Duom == '')
        Duom = 'Max';   
    if(reps == '')
        reps = 'Max';
    
    $.getJSON('ajax.php?module=upload&action=validateform', {Exercise:exercise, mWeight:MWeight, fWeight:FWeight, WUOM:Wuom, fHeight:FHeight, HUOM:Huom, mHeight:MHeight, Distance:dist, DUOM:Duom, Reps:reps},aresult);
}

function aresult(message)
{
    if($('#aselect_exercise').hasClass('inactive'))
        $('#aselect_exercise').removeClass('inactive');
    if(message == 1){
        alert('Must Enter Exercise Name!');
    }else if(message == 2){
        alert('Must Have at least one Attribute!');
    }else if(message == 3){
        alert('Must Select Exercise!');
    }else if(message == 4){
        alert('Can\'t have distance and height!');
    }else{
    document.getElementById('arowcounter').value++; 
    var ThisRoutineNumber = $('#aRoutineCounter').val();
    document.getElementById('aRoutine' + ThisRoutineNumber + 'Counter').value++;
    var ThisRowNumber = $('#arowcounter').val();
    var ThisRound = $('#aRoutine' + ThisRoutineNumber + 'RoundCounter').val();
    
    var Html = message.replace(/ThisRoutine/g, ThisRoutineNumber);
    if(ThisRoutineNumber == 1)
        DuplicateRound += Html;
    Html = Html.replace(/ThisRow/g, ThisRowNumber);
    Html = Html.replace(/RoundNo/g, ThisRound);
    
    //alert(Html);
    var exercises = $('#aactivity'+ThisRoutineNumber+'list');
    $(Html).appendTo(exercises);

    $('#aadd_exercise').html('');
    $('#amWeight').val('');
    $('#afWeight').val('');
    $('#amHeight').val('');
    $('#afHeight').val('');
    $('#aDistance').val('');
    $('#aReps').val('');
    $('#ainputs').html('');
    $("#aExercise option[value='none']").attr("selected","selected");
    }
}

function addnewAdvanced()
{
    $.getJSON('ajax.php?module=upload&action=validateform', $("#newform").serialize(),aresult);
}

function addNewActivityAdvanced()
{
    var Html ='<form action="index.php" id="newform" name="newform">';
    Html += '<input class="textinput" type="text" id="NewExercise" name="NewExercise" placeholder="Custom Activity"/>';
    Html += '<input class="textinput" size="7" type="text" id="Acronym" name="Acronym" placeholder="Acronym"/>';
    Html += '<input type="checkbox" name="attributes[]" value="Weight"/>Weight';
    Html += '<input type="checkbox" name="attributes[]" value="Height"/>Height';
    Html += '<input type="checkbox" name="attributes[]" value="Distance"/>Distance';
    Html += '<input type="checkbox" name="attributes[]" value="Reps"/>Reps';
    Html += '<input class="buttongroup" type="button" name="btnsubmit" value="Add" onclick="addnewAdvanced();"/>';
    Html +='</form><br/>';
    $('#add_advanced_exercise').html(Html);
    //$('.buttongroup').button();
    //$('.buttongroup').button('refresh');
    //$('.textinput').textinput();
}
</script>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Well rounded WOD</a></li>
        <li><a href="#tabs-2">Advanced WOD</a></li>
    </ul>
    <div id="tabs-1"> 
<div class="select_exercise">
<form action="index.php" id="wodform" name="wodform">
<input type="hidden" name="form" value="submitted"/>
<input type="hidden" name="module" value="upload"/>
<input type="hidden" name="WodTypeId" value="2"/>
<input type="hidden" name="rowcount" id="rowcounter" value="0"/>
<input type="hidden" name="RoutineCounter" id="RoutineCounter" value="1"/>
<input type="hidden" name="Routine1Counter" id="Routine1Counter" value="0"/>
<input type="hidden" name="Routine1RoundCounter" id="Routine1RoundCounter" value="1"/>
<textarea name="Notes" id="Notes" rows="4" cols="80" placeholder="Describe your WOD here"></textarea>
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
<textarea name="1_Notes" id="Notes_1" rows="1" cols="80" placeholder="Add notes here"></textarea>
<div id="Routine1Label"></div>
<div id="Routine1Round1Label"></div>
<div id="activity1list"></div> 
<div id="Routines"></div>   

<br/>
<br/>

<div style="height:75px;width:980px">
    <div style="float:left;width:150px" ><?php echo $Display->getExercises();?></div>
    <div style="float:right;width:700px" id="inputs"></div>
    <br/><br/>
    <div style="float:left;width:150px" ><?php echo $Display->getBenchmarks();?></div>
</div> 
<input type="button" value="Custom Activity" onClick="addNewActivity();"/>
<br/><br/>
<input type="button" name="addroutine" value="Add Routine" onClick="AddRoutine();"/>
<input type="button" name="addround" value="Add Round" onClick="AddRound();"/>
<input type="button" name="btnsubmit" value="Save WOD" onClick="PublishWod()"/>
</form><br/>
</div>
<div id="add_exercise"></div>   
</div>
<div id="tabs-2"> 
<div class="select_exercise">
<form action="index.php" id="advancedform" name="wodform">
<input type="hidden" name="form" value="submitted"/>
<input type="hidden" name="module" value="upload"/>
<input type="hidden" name="WodTypeId" value="2"/>
<input type="hidden" name="rowcount" id="arowcounter" value="0"/>
<input type="hidden" name="RoutineCounter" id="aRoutineCounter" value="1"/>
<input type="hidden" name="Routine1Counter" id="aRoutine1Counter" value="0"/>
<input type="hidden" name="Routine1RoundCounter" id="aRoutine1RoundCounter" value="1"/>
<textarea name="Notes" id="aNotes" rows="4" cols="80" placeholder="Describe your WOD here"></textarea>
<p>WOD Name:<input name="WodName" type="text"/> WOD Date:<input class="inputbox-required" type="text" name="WodDate" id="aWodDate" maxlength="25" placeholder="Use Calendar" value=""/>
<img src="images/calendar-blue.gif" alt="calendar" id="Start_trigger"/></p>
<script type="text/javascript">
      Calendar.setup({
        inputField : "WodDate",
        trigger    : "Start_trigger",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
</script>
<textarea name="1_Notes" id="aNotes_1" rows="1" cols="80" placeholder="Add notes here"></textarea>
<div id="aRoutine1Label"></div>
<div id="aRoutine1Round1Label"></div>
<div id="aactivity1list"></div> 
<div id="aRoutines"></div>   

<br/>
<br/>

<div style="height:75px;width:980px">
    <div style="float:left;width:150px" ><?php echo $Display->getAdvancedExercises();?></div>
    <div style="float:right;width:700px" id="ainputs"></div>
    <br/><br/>
    <div style="float:left;width:150px" ><?php echo $Display->getAdvancedBenchmarks();?></div>
</div> 
<input type="button" value="Custom Activity" onClick="addNewActivityAdvanced();"/>
<br/><br/>
<input type="button" name="addroutine" value="Add Routine" onClick="AddAdvancedRoutine();"/>
<input type="button" name="addround" value="Add Round" onClick="AddAdvancedRound();"/>
<input type="button" name="btnsubmit" value="Save WOD" onClick="PublishAdvancedWod()"/>
</form><br/>
</div>
<div id="add_exercise"></div>   
</div>
</div>