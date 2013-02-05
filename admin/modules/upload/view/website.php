
<script type='text/javascript'>

	$(function(){
		$('#tabs').tabs();

});

function PublishWod(){
    $.getJSON('ajax.php?module=upload&action=validateform', $("#wodform").serialize(),messagedisplay);
}

function PublishAdvancedWod(){
    $.getJSON('ajax.php?module=upload&action=validateform', $("#advancedform").serialize(),messagedisplay);
}

function getInputFields(exerciseId){
    $.getJSON('ajax.php?module=upload&action=getInputFields', {ExerciseId:exerciseId},inputdisplay);
}

function getAdvancedInputFields(exerciseId){
    $.getJSON('ajax.php?module=upload&action=getInputFields', {ExerciseId:exerciseId},ainputdisplay);
}

function inputdisplay(data){
    var routine = document.getElementById('wRoutineCounter').value;
    var Html = data.replace(/ThisRoutine/g, routine);
    $('#inputs').html(Html);
}

function ainputdisplay(data){
    var routine = document.getElementById('aRoutineCounter').value;
    var Html = data.replace(/ThisRoutine/g, routine);
    $('#ainputs').html(Html);
}

function AddRoutine(){
    var RoutineNumberAppend = document.getElementById('wRoutineCounter').value;
    document.getElementById('wRoutineCounter').value++;
    var ThisRoutineNumber = document.getElementById('wRoutineCounter').value; 
    var Exercises = '<div id="wRoutine_'+ThisRoutineNumber+'">';
    Exercises+= '<h2>Routine '+ThisRoutineNumber+'</h2>';
    Exercises+='<textarea name="'+ThisRoutineNumber+'_Notes" id="w_Notes_'+ThisRoutineNumber+'" rows="4" cols="80" placeholder="Add notes here"></textarea>';
   
    Exercises+='<div id="w_exercises_'+ThisRoutineNumber+'"></div>';
    Exercises+='<br/><br/>';
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
    Exercises+='<textarea name="'+ThisRoutineNumber+'_Notes" id="a_Notes_'+ThisRoutineNumber+'" rows="4" cols="80" placeholder="Add notes here"></textarea>';
    
    Exercises+='<div id="a_exercises_'+ThisRoutineNumber+'"></div>';
    Exercises+='<br/><br/>';
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
    var exercise = $('#Exercise').val();
    var MWeight = $('#mWeight').val();
    var FWeight = $('#fWeight').val();
    var Wuom = $('#WUOM').val();
    var MHeight = $('#mHeight').val();
    var FHeight = $('#fHeight').val();
    var Huom = $('#HUOM').val();
    var dist = $('#Dist').val();
    var Duom = $('#DUOM').val();
    var reps = $('#Reps').val();
    
    $.getJSON('ajax.php?module=upload&action=validateform', {Exercise:exercise, mWeight:MWeight, fWeight:FWeight, WUOM:Wuom, fHeight:FHeight, HUOM:Huom, mHeight:MHeight, Dist:dist, DUOM:Duom, Reps:reps},wresult);
}

function addexerciseAdvanced()
{
    var exercise = $('#aexerciseselect').val();
    var MWeight = $('#amWeight').val();
    var FWeight = $('#afWeight').val();
    var Wuom = $('#aWUOM').val();
    var MHeight = $('#amHeight').val();
    var FHeight = $('#afHeight').val();
    var Huom = $('#aHUOM').val();
    var dist = $('#aDist').val();
    var Duom = $('#aDUOM').val();
    var reps = $('#aReps').val();
    
    $.getJSON('ajax.php?module=upload&action=validateform', {Exercise:exercise, mWeight:MWeight, fWeight:FWeight, WUOM:Wuom, fHeight:FHeight, HUOM:Huom, mHeight:MHeight, Dist:dist, DUOM:Duom, Reps:reps},aresult);
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
    document.getElementById('wrowcounter').value++;
    var ThisRoutineNumber = $('#wRoutineCounter').val();
    var ThisRowNumber = $('#wrowcounter').val();
    var Html = message.replace(/ThisRow/g, ThisRowNumber);
    Html = Html.replace(/ThisRoutine/g, ThisRoutineNumber);
    var exercises = $('#w_exercises_'+ThisRoutineNumber+''); 
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

function aresult(message)
{
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
    var ThisRowNumber = $('#arowcounter').val();
    var Html = message.replace(/ThisRow/g, ThisRowNumber);
    Html = Html.replace(/ThisRoutine/g, ThisRoutineNumber);
    var exercises = $('#a_exercises_'+ThisRoutineNumber+'');        
        $(Html).appendTo(exercises);

    $('#add_advanced_exercise').html('');
    $('#amWeight').val('');
    $('#afWeight').val('');
    $('#amHeight').val('');
    $('#afHeight').val('');
    $('#aDistance').val('');
    $('#aReps').val('');
    $('#ainputs').html('');
    $("#aexerciseselect option[value='none']").attr("selected","selected");
    }
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
<div class="select_exercise">
<form action="index.php" id="wodform" name="wodform">
<input type="hidden" name="form" value="submitted"/>
<input type="hidden" name="module" value="upload"/>
<input type="hidden" name="WodTypeId" value="2"/>
<input type="hidden" name="rowcount" id="wrowcounter" value="0"/>
<input type="hidden" name="RoutineCounter" id="wRoutineCounter" value="1"/>
<textarea name="Notes" id="w_Notes" rows="4" cols="80" placeholder="Describe your WOD here"></textarea>
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
<textarea name="1_Notes" id="w_Notes_1" rows="1" cols="80" placeholder="Add notes here"></textarea>
      
<div id="w_exercises_1"></div>   

<br/>
<br/>
    </div>
<div style="height:42px;width:980px">
    <div style="float:left;width:180px" ><?php echo $Display->getExercises();?></div>
    <div style="float:left;width:800px" id="inputs"></div>
</div> 
<input type="button" value="Custom Activity" onClick="addNewActivity();"/>
<br/><br/>
        <input type="button" name="add" value="Add Routine" onClick="AddRoutine();"/>
        <input type="submit" name="btnsubmit" value="Save WOD"/>
        </form><br/>
 </div>
<div id="add_exercise"></div>   
    </div>
    <div id="tabs-2"> 
<div class="select_exercise">
<form action="index.php" id="advancedform" name="advancedform">
<input type="hidden" name="form" value="submitted"/>
<input type="hidden" name="WodTypeId" value="4"/>
<input type="hidden" name="rowcount" id="arowcounter" value="0"/>
<input type="hidden" name="RoutineCounter" id="aRoutineCounter" value="1"/>
<textarea name="Notes" id="a_Notes" rows="4" cols="80" placeholder="Describe your WOD here"></textarea>
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
<textarea name="1_Notes" id="a_Notes_1" rows="1" cols="80" placeholder="Add notes here"></textarea>
   
<div id="a_exercises_1"></div>   

<br/>
<br/>
    </div>
<div style="height:42px;width:980px">
    <div style="float:left;width:180px" >
 <?php echo $Display->getAdvancedExercises();?>
    </div><div style="float:left;width:800px" id="ainputs"></div>
</div> 
<input type="button" value="Custom Activity" onClick="addNewActivityAdvanced();"/>
<br/><br/>

        <input type="button" name="" value="Add Routine" onClick="AddAdvancedRoutine();"/>
        <input type="submit" name="btnsubmit" value="Save WOD"/>
        </form><br/>
 </div>
<div id="add_advanced_exercise"></div>  
    </div>
</div>