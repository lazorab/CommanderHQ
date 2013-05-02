<script type="text/javascript">
$('#back').html('<img alt="Back" onclick="OpenThisPage(\'<?php echo $_SERVER ['HTTP_REFERER'];?>\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    
    $(function(){
        $('#tab1').addClass('active');
        $('#details1').html('<?php echo $Display->WorkoutDetails("2");?>');
        $('.buttongroup').button();
        $('.buttongroup').button('refresh');
        var el = $('#AjaxOutput');
        el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true});       
    });
    
function Tabs(tab)
{
    if(tab == 1){
        $('#tab2').removeClass('active');
        $('#tab1').addClass('active');
        $('#details1').html('<?php echo $Display->WorkoutDetails("2");?>');
        $('#details2').html('');
    }else{
        $('#tab1').removeClass('active');
        $('#tab2').addClass('active');
        $('#details1').html('');
        $('#details2').html('<?php echo $Display->WorkoutDetails("4");?>');
    }
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    var el = $('#AjaxOutput');
    el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true});
}

function UpdateActivity(ActivityId, Attributes)
{
    var AttributesArray = Attributes.split('_');
    for(i=0; i < AttributesArray.length;i++){
        $("#"+ActivityId+"_"+AttributesArray[i]+"_html").html($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
        $("#"+ActivityId+"_"+AttributesArray[i]+"").val($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
    }  
}

function OpenHistory(ExerciseId)
{
    if($('#'+ExerciseId+'').hasClass('active')){
        $('#'+ExerciseId+'').removeClass('active');
    }else{
        $('#'+ExerciseId+'').addClass('active');
    } 
}

function getWOD()
{    
    $('#AjaxLoading').html('<img <?php echo $RENDER->NewImage("ajax-loader.gif");?> src="/css/images/ajax-loader.gif" />');
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=wod\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=mygym',data:{wod:'display'},dataType:"html",success:display});
    //$.ajax({url:'ajax.php?module=mygym',data:{topselection:'mygym'},dataType:"html",success:topdisplay});	
}

function getFeedDetails(ThisWorkout)
{
    $('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=mygym',data:{Workout:ThisWorkout},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=mygym',data:{topselection:ThisWorkout},dataType:"html",success:topselectiondisplay});
}

function topdisplay(data)
{
     var codes = '<div class="ui-grid-c">';
    codes += '<div class="ui-block-a"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#3f2b44" value="Weight" readonly="readonly"/></div>';
    codes += '<div class="ui-block-b"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#66486e" value="Height" readonly="readonly"/></div>';
    codes += '<div class="ui-block-c"><input type="text" data-role="none" style="width:80%;color:white;font-weight:bold;background-color:#6f747a" value="Distance" readonly="readonly"/></div>';
    codes += '<div class="ui-block-d"><input type="text" data-role="none" style="width:80%;color:black;font-weight:bold;background-color:#ccff66" value="Reps" readonly="readonly"/></div>';
    codes += '</div>';   
    $('#toplist').listview();
    $('#toplist').html(data);
    $('#toplist').listview('refresh');
    $('#colorcodes').html(codes);
}

function display(data)
{

    if(data == 'Must First Register Gym!'){
        alert('Must First Register Gym!\nYou will be redirected now');
        window.location = 'index.php?module=profile';
    }
    else{
 
	$('#AjaxOutput').html(data);
    }
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('.controlbutton').button();
    $('.controlbutton').button('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
    $('#AjaxLoading').html('');	
}

function Save()
{
    $("#TimeToComplete").val($('#clock').html());
    var timeval = $("#TimeToComplete").val();
    $.getJSON('ajax.php?module=mygym&action=validateform&TimeToComplete='+timeval+'', $("#wodform").serialize(),messagedisplay);
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

function editFunction(ThisId)
{

var x = document.getElementById(""+ThisId+"").innerHTML;

var newvalue = prompt("Edit",x);

if (newvalue!=null)
  {
  document.getElementById(""+ThisId+"").innerHTML=newvalue;
  }
}

function MakeBaseline(WOD)
{
    var c=document.getElementById('baseline');
    if(c.checked == false){
    $.ajax({url:'ajax.php?module=mygym&action=formsubmit',data:{baseline:'no'},dataType:"html"});                      
    }else if(c.checked == true){
    var WodDetail = WOD.split('_');
    var WodId = WodDetail[0];
    var WodTypeId = WodDetail[1];
    $.ajax({url:'ajax.php?module=mygym&action=formsubmit',data:{baseline:'yes',WorkoutId:WodId,WodTypeId:WodTypeId},dataType:"html"});              
    }              
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
   $.ajax({url:'ajax.php?module=mygym&action=formsubmit&WorkoutId='+WodId+'&WodTypeId='+WodTypeId+'',data:$('#'+ActivityForm+'').serialize(),dataType:"html",success:messagedisplay});          
   $.ajax({url:'ajax.php?module=mygym',data:{history:'refresh', ExerciseId:ExerciseId},dataType:"html",success:function(html) {
        $('#'+ActivityForm+'_History').html(html);   
   }});      
    //'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy)
}
</script>

<br/>
<div id="AjaxOutput">       
    <?php echo $Display->Output();?>
</div>