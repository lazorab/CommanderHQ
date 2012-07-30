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
	$('#customtype').selectmenu();
	$('#customtype').selectmenu('refresh');
}

function addNewExercise(exercise)
{
	var new_exercise = $('#new_exercise');
	var row_count = document.getElementById('rowcounter').value;
	var i=0;
	row_count++;
	i = row_count;
	$('<div id="row_' +row_count+ '"><div class="ui-block-a"><a href="#" onclick="removeRow('+ row_count +')" class="remove" data-role="button" data-mini="true" data-icon="delete" data-iconpos="notext">Remove</a><input style="float:left" type="text" size="6" name="exercise_' +row_count+ '" value="'+exercise+'" readonly="readonly"/><div class="clear"></div></div><div class="ui-block-b" id="block-b_input_' + i +'"></div><div class="ui-block-c" id="block-c_input_' + i +'"></div></div>').appendTo(new_exercise);
	document.getElementById('rowcounter').value = row_count;
	getInputs(exercise);
	$('.remove').button();
	$('.remove').button('refresh');
}

function getInputs(type)
{

 var custom_input = $('#custom_input_' + i +'');

 $.getJSON("ajax.php?module=custom",{chosenexercise:type},function(json) {
	var j = 0;
	var html = '';
    $.each(json, function() {
		var i = document.getElementById('rowcounter').value;
		if(this.Attribute == 'TimeToComplete')
  {
    $('#clock_input').html('<input type="text" id="clock" name="' + this.recid + '___' + this.Attribute + '" value="00:00:0"/><?php echo $Display->getStopWatch();?>');
	html = 'Timed';
	$('.buttongroup').button();
	$('.buttongroup').button('refresh');
  }else if(this.Attribute == 'CountDown'){
    html ='<input type="time" id="input_' + i +'" size="10" name="' + this.recid + '___' + this.Attribute + '" value="" placeholder="Count Down Time (mm:ss)" />';
  }else if(this.Attribute == 'Weight'){
    html ='<input type="number" id="input_' + i +'" size="10" name="' + this.recid + '___' + this.Attribute + '" value="" placeholder="Weight" />';
  }else if(this.Attribute == 'Reps'){
    html ='<input type="number" id="input_' + i +'" size="10" name="' + this.recid + '___' + this.Attribute + '" value="" placeholder="Reps" />';
  }else if(this.Attribute == 'Tabata'){
  
  }else if(this.Attribute == 'Other'){
  
  }else if(this.Attribute == 'Distance'){
      html ='<input type="number" id="input_' + i +'" size="10" name="' + this.recid + '___' + this.Attribute + '" value="" placeholder="' + this.Attribute + '" />';
  }
  
		if(j==1){
			$('#block-b_input_' + i +'').html(html);
		}else{
			$('#block-c_input_' + i +'').html(html);
		}
		j++;
    });
});
$("#exercise option[value='']").attr("selected","selected");
  return false;	
}

function removeRow(id)
{
	$('#row_' +id + '').remove();
	if(document.getElementById('clock_input').html != ''){
		$('#clock_input').html('');
	}
	document.getElementById('rowcounter').value--;
}

</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->MainOutput();?>
</div>
