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

function getCustomInputs(type)
{
  var custom_input = $('#custom_input');
  var field_count = document.getElementById('fieldcounter').value;
	var i=0;
  field_count++;
  i = field_count;
  if(type == 'Timed')
  {
	$("#customtype option[value='Timed']").attr("disabled","disabled");
	$("#customtype option[value='AMRAP']").attr("disabled","disabled");
    $('<div id="custom_input_' + i +'"><input style="float:left" type="text" id="input_' + i +'" size="20" name="Timed_' + i +'" value="Timed" readonly="readonly"/><a href="#" onclick="removeInput(\'custom_input_' + i +'\', \'' + type + '\')" class="remove" data-role="button" data-mini="true" data-icon="delete" data-iconpos="notext">Remove</a><br/></div><div class="clear"></div>').appendTo(custom_input);
  }else if(type == 'AMRAP'){
  	$("#customtype option[value='Timed']").attr("disabled","disabled");
	$("#customtype option[value='AMRAP']").attr("disabled","disabled");
    $('<div id="custom_input_' + i +'"><input style="float:left" type="time" id="input_' + i +'" size="20" name="AMRAP_' + i +'" value="" placeholder="Enter Time (mm:ss)" /><a href="#" onclick="removeInput(\'custom_input_' + i +'\', \'' + type + '\')" class="remove" data-role="button" data-mini="true" data-icon="delete" data-iconpos="notext">Remove</a><br/></div><div class="clear"></div>').appendTo(custom_input);
  }else if(type == 'Weight'){
	$("#customtype option[value='Weight']").attr("disabled","disabled");
    $('<div id="custom_input_' + i +'"><input style="float:left" type="number" id="input_' + i +'" size="20" name="Weight_' + i +'" value="" placeholder="Enter Weight" /><a href="#" onclick="removeInput(\'custom_input_' + i +'\', \'' + type + '\')" class="remove" data-role="button" data-mini="true" data-icon="delete" data-iconpos="notext">Remove</a><br/></div><div class="clear"></div>').appendTo(custom_input);
  }else if(type == 'Reps'){
	$("#customtype option[value='Reps']").attr("disabled","disabled");
    $('<div id="custom_input_' + i +'"><input style="float:left" type="number" id="input_' + i +'" size="20" name="Reps_' + i +'" value="" placeholder="Enter Reps" /><a href="#" onclick="removeInput(\'custom_input_' + i +'\', \'' + type + '\')" class="remove" data-role="button" data-mini="true" data-icon="delete" data-iconpos="notext">Remove</a><br/></div><div class="clear"></div>').appendTo(custom_input);
  }else if(type == 'Tabata'){
  
  }else if(type == 'Other'){
  
  }
document.getElementById('fieldcounter').value = field_count;
  	$('.remove').button();
	$('.remove').button('refresh');
  return false;	
}

function removeInput(id, type)
{
	$('#' +id + '').remove();
	if(type == 'Timed' || type == 'AMRAP'){
		$("#customtype option[value='Timed']").removeAttr("disabled");
		$("#customtype option[value='AMRAP']").removeAttr("disabled");
	}
	else{
		$("#customtype option[value='" + type + "']").removeAttr("disabled");
	}
	document.getElementById('fieldcounter').value--;
}

$(function() {
  var scntDiv = $('#p_scents');

  var i = $('#p_scents p').size() + 1;

  $('#newcount').value = i;
  $('#addScnt').on('click', function() {
                     $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="newattribute_' + i +'" value="" placeholder="Attribute Name" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
                     i++;
                     return false;
                     });
  
  $('#remScnt').on('click', function() {
                     if( i > 1 ) {
                     $(this).parents('p').remove();
                     i--;
                     }
                     return false;
                     });
					 
  $('#customtype').on('change', function() {

                     });	 
  });

</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->Output();?>
</div>
