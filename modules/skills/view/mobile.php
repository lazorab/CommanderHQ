<?php
$Overthrow='';
$Device = new DeviceManager;
if($Device->IsGoogleAndroidDevice()) { 
    $Overthrow=' overthrow';?>
        <script src="/js/overthrow.js"></script>
<?php } ?>

<script type="text/javascript">   

function getCategories(thislevel)
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=skills\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=skills',data:{level:thislevel},dataType:"html",success:display});    
}

function getSkills(cat, thislevel)
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=skills\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=skills',data:{category:cat, level:thislevel},dataType:"html",success:display});    
}

function SaveTheseResults(WOD,ActivityForm)
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
   $.ajax({url:'ajax.php?module=skills&action=formsubmit&WorkoutId='+WodId+'&WodTypeId='+WodTypeId+'',data:$('#'+ActivityForm+'').serialize(),dataType:"html",success:messagedisplay});          
   $.ajax({url:'ajax.php?module=skills',data:{history:'refresh', ExerciseId:ExerciseId},dataType:"html",success:function(html) {
        $('#'+ActivityForm+'_History').html(html);   
   }});      
    //'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy)
}

function messagedisplay(message)
{
    if(message == 'Success'){
        $( "#popupFeedback" ).popup("open");
    }  
    else
        alert(message);
}

function display(data)
{
    var el = $('#AjaxOutput');
    $('#AjaxOutput').html(data);
    $('#toplist').listview();
    $('#toplist').listview('refresh');
    $('#exercise').selectmenu();
    $('#exercise').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
    el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true}); 
}

</script>

<br/>
<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>