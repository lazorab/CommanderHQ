function getContent(selection)
{
    $.getJSON("ajax.php?module=custom",{baseline:selection},display);
}

function getCustomExercise(id)
{
    $.getJSON("ajax.php?module=custom",{customexercise:id},display);
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

        Html+= '<?php echo $Display->getStopWatch(CustomType);?>';
        
    $('#clock_input').html(Html);
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('#addround').textinput();
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
        $('#btnsubmit').html('<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>');
    }
    $.each(json, function() {
        if(this.BenchmarkId > 0 && j == 0){
           html +='<input class="benchmark_' + this.BenchmarkId + '" type="hidden" name="benchmarkId" value="' + this.BenchmarkId + '"/>';
		   html += '<div class="benchmark_' + this.BenchmarkId + '"><input onclick="RemoveFromList(' + attributecount + ',' + this.BenchmarkId + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="' + exercise + '"/>';
		   html +='' + exercise + '</div>';
        }

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
                    html +='<div id="row_' + i + '" class="benchmark_' + this.BenchmarkId + '">';
                }
                else{
                    html +='</div><div id="row_' + i + '" class="benchmark_' + this.BenchmarkId + '">';
                }           
           
                html +='<div class="ui-block-a"></div><div class="ui-block-b">Round ' + this.RoundNo + '</div><div class="ui-block-c"></div>';
             
                html +='<div class="ui-block-a" style="font-size:small">';
                if(this.BenchmarkId == 0){
                    html += '<input onclick="RemoveFromList(' + i + ',0)" type="checkbox" name="exercise_' + i + '" checked="checked" value="';
                    html +='' + this.ActivityName + '';
                    html +='"/>';
                }
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
                    html +='<div id="row_' + i + '" class="benchmark_' + this.BenchmarkId + '">';
                }
                else{
                    html +='</div><div id="row_' + i + '" class="benchmark_' + this.BenchmarkId + '">';
                }
           
                html +='<div class="ui-block-a"></div><div class="ui-block-b"></div><div class="ui-block-c"></div>';
                html +='<div class="ui-block-a" style="font-size:small">';
                if(this.BenchmarkId == 0){
                    html += '<input onclick="RemoveFromList(' + i + ',0)" type="checkbox" name="exercise_' + i + '" checked="checked" value="';
                    html +='' + this.ActivityName + '';
                    html +='"/>';
                }
                html +='' + this.ActivityName + '';
                html += '<div class="clear"></div>';
                html +='</div>';
           }
           	
           if(this.Attribute == 'Distance' || this.Attribute == 'Weight'){
			var Style='';
                if(this.Attribute == 'Distance'){
					Style='style="width:75%;color:white;font-weight:bold;background-color:#6f747a"';
                    if('<?php echo $Display->SystemOfMeasure();?>' == 'imperial')
                        Unit = 'yards';
                    else
                        Unit = 'metres';
                }		
                else if(this.Attribute == 'Weight'){
					Style='style="width:75%;color:white;font-weight:bold;background-color:#3f2b44"';
                    if('<?php $Display->SystemOfMeasure();?>' == 'imperial')
                        Unit = 'lbs';
                    else
                        Unit = 'kg';
                }
                else if(this.Attribute == 'Height'){
					Style='style="width:75%;color:white;font-weight:bold;background-color:#66486e"';
                    if('<?php $Display->SystemOfMeasure();?>' == 'imperial')
                        Unit = 'inches';
                    else
                        Unit = 'cm';
                }				
           
                Bhtml +='<div class="ui-block-b">';
                Bhtml +='<input class="textinput" size="6" type="number" data-inline="true" name="' + this.RoundNo + '___' + this.recid + '___' + this.Attribute + '"';
                Bhtml +=' value="' + this.AttributeValue + '"';
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
                Chtml +='<input class="textinput" ' + Style + 'size="6" type="number" data-inline="true" name="' + this.RoundNo + '___' + this.recid + '___' + this.Attribute + '"';
                Chtml +=' value="' + this.AttributeValue + '"';
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

function RemoveFromList(RowId,BenchMarkId)
{
	if(BenchMarkId > 0){
		$('.benchmark_' + BenchMarkId + '').remove();
		document.getElementById('rowcounter').value = document.getElementById('rowcounter').value - (RowId - 1);
	}
	else if(RowId > 0){
		$('#row_' + RowId + '').remove();
		document.getElementById('rowcounter').value--;
	}
		
	if(document.getElementById('clock_input').html != ''){
		$('#clock_input').html('');
	}
	
    if(document.getElementById('rowcounter').value == 0){
        $('#btnsubmit').html('');
    }
}

function customsubmit()
{
    $.getJSON('ajax.php?module=custom', $("#customform").serialize(),display);
    window.location.hash = '#message';
}

function addnew()
{
    var NewExercise = document.getElementById('NewExercise').value;
    $.getJSON('ajax.php?module=custom', {newexercise:NewExercise},display);
    window.location.hash = '#message';
}

function addRound()
{
    document.getElementById('addround').value++; 
    //$.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
}