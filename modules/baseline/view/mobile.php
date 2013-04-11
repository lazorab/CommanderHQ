<script type="text/javascript">	

function getBaseline()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=baseline\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $('#toplist').html('<li>Baseline</li>');
    $.getJSON("ajax.php?module=baseline",{baseline:'Baseline'},display);
    $('#toplist').listview();
    $('#toplist').listview('refresh');
}

function getBenchmark(id)
{
    $.getJSON("ajax.php?module=baseline",{benchmark:id},display);
}

function getContent(selection)
{
    $.getJSON("ajax.php?module=baseline",{baseline:selection},display);
}

function getCustomExercise(id)
{
    $.getJSON("ajax.php?module=baseline",{customexercise:id, baseline:'custom'},display);
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#toplist').listview();
    $('#toplist').listview('refresh');
    $("input").checkboxradio ();
    $("input").closest ("div:jqmData(role=controlgroup)").controlgroup ();
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
}

$(function() {
  var scntDiv = $('#p_scents');
  var i = $('#p_scents p').size() + 1;
  $('#newcount').value = i;
  $('#addScnt').live('click', function() {
                     $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="newattribute_' + i +'" value="" placeholder="Attribute Name" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
                     i++;
                     return false;
                     });
  
  $('#remScnt').live('click', function() {
                     if( i > 1 ) {
                     $(this).parents('p').remove();
                     i--;
                     }
                     return false;
                     });
});

function baselinesubmit()
{
    $.getJSON('ajax.php?module=baseline&action=validateform', $("#baselineform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    if(message == 'Success'){
        $( "#popupFeedback" ).popup("open");
        resetclock();
    }  
    else
        alert(message);
}

function SaveTheseResults(WOD, ActivityForm)
{    
    var WodDetail = WOD.split('_');
    var WodId = WodDetail[0];
    var WodTypeId = WodDetail[1];    
    //ActivityForm = RoutineNo_RoundNo_OrderBy_'.$Activity->ExerciseId.'
   var Detail = ActivityForm.split('_');
   var ExerciseId = Detail[3];   
   //var TimeToComplete = $('#clock').html();
   //var TimeField = ''+Detail[0]+'_'+Detail[1]+'_'+ExerciseId+'_TimeToComplete_0_'+Detail[2]+'';
//1_1_81_Reps_0_1
   $.ajax({url:'ajax.php?module=baseline&action=formsubmit&WorkoutId='+WodId+'&WodTypeId='+WodTypeId+'',data:$('#'+ActivityForm+'').serialize(),dataType:"html",success:messagedisplay});          
   $.ajax({url:'ajax.php?module=baseline',data:{history:'refresh', ExerciseId:ExerciseId},dataType:"html",success:function(html) {
        $('#'+ActivityForm+'_History').html(html);   
   }});      
    //'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy)
}

</script>
<br/>

<div id="AjaxOutput">  
    <?php echo $Display->Output();?>
</div>
