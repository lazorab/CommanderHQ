<script type="text/javascript">	

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
    $('#exercise').selectmenu();
    $('#exercise').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
}

function addNewExercise(exercise)
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
	var ThisClass = '';
    if(i < 1){
        $('#btnsubmit').html('<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>');
    }
    $.each(json, function() {
        if(this.BenchmarkId > 0 && j == 0){
           html +='<input class="benchmark_' + this.BenchmarkId + '" type="hidden" name="benchmarkId" value="' + this.BenchmarkId + '"/>';
		   html += '<div class="benchmark_' + this.BenchmarkId + '"><input onclick="RemoveFromList(' + attributecount + ',' + this.BenchmarkId + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="' + exercise + '"/>';
		   html +='' + exercise + '</div>';
        }
        if(this.Attribute == 'TimeToComplete'){
			$('#clock_input').html('<input type="text" id="clock" name="0___' + this.recid + '___' + this.Attribute + '" value="00:00:0"/><?php echo $Display->getStopWatch();?>');
        }
        else if(this.Attribute == 'CountDown'){
           $('#clock_input').html('<input type="time" id="input_' + i + '" size="10" name="0___' + this.recid + '___' + this.Attribute + '" value="" placeholder="mm:ss"/>');
        }
        else{
           
           if(ThisRound != this.RoundNo){
           
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
                if(this.Attribute == 'Distance'){
                    if('<?php echo $_SESSION['measurement'];?>' == 'imperial')
                        Unit = 'yards';
                    else
                        Unit = 'metres';
                }		
                else if(this.Attribute == 'Weight'){
                    if('<?php echo $_SESSION['measurement'];?>' == 'imperial')
                        Unit = 'lbs';
                    else
                        Unit = 'kg';
                }
           
                Bhtml +='<div class="ui-block-b">';
                Bhtml +='<input class="textinput" size="6" type="number" data-inline="true" name="' + this.RoundNo + '___' + this.recid + '___' + this.Attribute + '"';
                Bhtml +=' value="' + this.AttributeValue + '"/>';
                Bhtml +='</div>';		
                if(Chtml != ''){
                    html +='' + Bhtml + '' + Chtml + '';
                    Chtml = '';
                    Bhtml = '';
                }
           }
           else if(this.Attribute == 'Reps'){
                Chtml +='<div class="ui-block-c">';
                Chtml +='<input class="textinput" size="6" type="number" data-inline="true" name="' + this.RoundNo + '___' + this.recid + '___' + this.Attribute + '"';
                Chtml +=' value="' + this.AttributeValue + '"/>';
                Chtml +='</div>';
                if(Bhtml != ''){
                    html +='' + Bhtml + '' + Chtml + '';
                    Bhtml = '';
                    Chtml = '';
                }
           }
           }

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
</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->MainOutput();?>
</div>
