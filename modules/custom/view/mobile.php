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
    var new_exercise = $('#new_exercise');
    var i = document.getElementById('rowcounter').value;
    var j = 0;
    var html = '';
    var Bhtml = '';
    var Chtml = '';
    ThisRound = '';
    ThisExercise = '';
    if(i < 1){
        $('#btnsubmit').html('<input class="buttongroup" type="button" name="btnsubmit" value="Save" onclick="customsubmit();"/>');
    }
    $.each(json, function() {
        if(this.BenchmarkId > 0 && j == 0){
           html +='<input type="hidden" name="benchmarkId" value="' + this.BenchmarkId + '"/>';
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
                    html +='<div id="row_' + i + '">';
                }
                else{
                    html +='</div><div id="row_' + i + '">';
                }           
           
                html +='<div class="ui-block-a"></div><div class="ui-block-b">Round ' + this.RoundNo + '</div><div class="ui-block-c"></div>';
             
                html +='<div class="ui-block-a" style="font-size:small">';

                html += '<input onclick="removeRow(' + i + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="';
                if(j == 0){
                    html +='' + exercise + '';
                }
                else{
                    html +='' + this.ActivityName + '';
                }
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
                html += '<input onclick="removeRow(' + i + ')" type="checkbox" name="exercise_' + i + '" checked="checked" value="';
                if(j == 0){
                    html +='' + exercise + '';
                }
                else{
                    html +='' + this.ActivityName + '';
                }
                html +='"/>';
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

function removeRow(id)
{
	$('#row_' + id + '').remove();
	if(document.getElementById('clock_input').html != ''){
		$('#clock_input').html('');
	}
	document.getElementById('rowcounter').value--;
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
