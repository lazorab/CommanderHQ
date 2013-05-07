        <style type="text/css">
			
			.swipeleft {
			
				cursor: -moz-grab;
				
			}
			
			.swipeleft:active {
			
				cursor: -moz-grabbing;
				
			}
</style> 
                       
<script type="text/javascript" src="js/tabatatimer.js"></script>
<script type="text/javascript" src="js/jquery.cj-swipe.js"></script>
<script type='text/javascript'>
$('#back').html('<img alt="Back" onclick="OpenThisPage(\'<?php echo $_SERVER ['HTTP_REFERER'];?>\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

var LastActivity = '';
var DuplicateRound;
var DuplicateRoutine;
var OrderBy=0;

		$( document ).on( "pageinit", ".pages", function() {
			$( "#autocomplete" ).on( "listviewbeforefilter", function ( e, data ) {
				var $ul = $( this ),
					$input = $( data.input ),
					value = $input.val(),
					html = "";
				$ul.html( "" );
				if ( value && value.length > 0 ) {
					//$ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
					//$ul.listview( "refresh" );
					$.ajax({
						url: "ajax.php?module=custom",
						dataType: "jsonp",
						crossDomain: true,
						data: {
							q: $input.val()
						}
					})
.then( function ( response ) {
    html += '<br/><li style="font-style:italic;color:blue" class="activity" id="0">Create New Activity</li>';
  $.each( response, function ( i, val ) {
    html += '<li class="activity" id="' + val.ExerciseId + '">' + val.ActivityName + '</li>';
  });
  $ul.html( html );
  $ul.listview( "refresh" );
  $ul.trigger( "updatelayout");
  $('.activity').click(function(){
    var id = $(this).attr('id');  
    if(id == 0)
        addNewExercise()
    else    
        ExerciseInputs(id);
    $input.val($('#'+id+'').html());
  $ul.html('');
  $ul.listview( "refresh" );
  $ul.trigger( "updatelayout");    
  });
});
				}
			});
		});

function getContent(selection)
{  
    $.ajax({url:'ajax.php?module=custom',data:{baseline:selection},dataType:"html",success:display});  
}

function getCustomExercise(id)
{
    $.ajax({url:'ajax.php?module=custom',data:{customexercise:id},dataType:"html",success:display});  
}

function messagedisplay(message)
{  
    if(message == 'Success'){
        var r=confirm("Successfully Saved!\nWould you like to provide us with feedback?");
        if (r==true)
        {
            window.location = 'index.php?module=contact';
        }
        else
        {
            reset();
        }
    }  
    else
        alert(message); 
}

function display(data)
{
    var el = $('#AjaxOutput');
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');
    $("#benchmark").selectmenu();
    $("#benchmark").selectmenu("refresh");
    $('.textinput').textinput();
    $('.numberinput').textinput();
    el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true});    
}

function DuplicateLastActivity()
{
    if(LastActivity != ''){
        addactivitydisplay(LastActivity);
        //OrderBy++;
        //ExerciseInputs(LastActivity); 
    }else{
        alert('Nothing to copy yet!');
    }
}

function DisplayBenchmark(data)
{
    document.getElementById('rowcounter').value++;
    var el = $('#AjaxOutput');
    var RoutineNo = $('#RoutineCounter').val();
    var RoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();    
    Html = data.replace(/RoutineNo/g, RoutineNo);
    Html = Html.replace(/RoundNo/g, RoundNo);    
    
    $('#activity'+RoutineNo+'list').append(Html);
    $("#benchmark option[value='none']").attr("selected","selected");
    el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true});
}

function AddBenchmark(Id)
{
    $.ajax({url:'ajax.php?module=custom',data:{benchmarkId:Id},dataType:"html",success:DisplayBenchmark}); 
}

function addNewExercise()
{
    if($('#add_exercise').html() != ''){
        $('#add_exercise').html('');
    }else{
    var RoutineNo = $('#RoutineCounter').val();
    var RoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();
    //var OrderBy = $('#Round' + RoundNo + 'Counter').val();
    var Html ='<div class="AddNewActivityAttributes">';
    Html += '<h2>New Activity</h2>';
    Html += '<form id="newactivityform">';
    Html += '<div style="float:left;margin:0"><input style="width:225px" type="text" id="NewExercise" name="NewExercise" value="" placeholder="Activity Name"/></div>';
    Html += '<div style="float:left;margin:20px 0 0"><input style="width:225px" type="text" id="Acronym" name="Acronym" value="" placeholder="Acronym for Activity?"/></div>';
    Html += '<div style="float:left;margin:20px 15px 0 0"><input style="width:85px" placeholder="Weight(<?php echo $Display->UserUnitOfMeasure('Weight');?>)" type="number" id="NewActivityWeight" name="NewActivityWeight"/></div>';
    Html += '<div style="float:left;margin:20px 0 0 25px"><input style="width:85px" placeholder="Height(<?php echo $Display->UserUnitOfMeasure('Height');?>)" type="number" id="NewActivityHeight" name="NewActivityHeight"/></div>';
    Html += '<div style="float:left;margin:20px 15px 0 0"><input style="width:85px" placeholder="Distance" type="number" id="NewActivityDistance" name="NewActivityDistance"/></div>';
    Html += '<div style="float:left;margin:20px 0 0 25px"><select style="width:85px" id="NewActivityDistanceUOM" name="NewActivityDistanceUOM">';
    if('<?php echo $Display->SystemOfMeasure();?>' == 'Metric'){
        Html += '<option value="2">Metres</option>';
        Html += '<option value="1">Kilometres</option>';
        Html += '</select>';               
    }else{
        Html += '<option value="3">Miles</option>';
        Html += '<option value="4">Yards</option>';
        Html += '</select>';                
    } 
    Html += '</div><div class="clear"></div>';

    Html += '<div style="float:left;margin:20px 0 0 0"><input style="width:85px" type="number" id="NewActivityReps" placeholder="Reps" name="NewActivityReps"/></div>';

    Html += '<div style="float:right;margin:20px 0 0 0"><button class="controlbutton" data-inline="true" onClick="addnew(\''+RoundNo+'\', \''+OrderBy+'\');">Add Activity</button></div>';
    Html += '</form></div><br/><div class="clear"></div>';

    $('#add_exercise').html(Html);
    $('.controlbutton').button();
    $('.controlbutton').button('refresh');
    $('.textinput').textinput();
    $('.numberinput').textinput();
    }
}

function addactivitydisplay(data)
{
    if(data.substring(0,5) == 'Error'){
        alert(data); 
    }else{
    LastActivity = data;    
    OrderBy++;     
    var RoutineNo = $('#RoutineCounter').val();   
    var RoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();

    document.getElementById('rowcounter').value++;
    document.getElementById('Routine' + RoutineNo + 'Round' + RoundNo + 'Counter').value++;
    var RowNo = $('#rowcounter').val();
    var Html = data.replace(/RowNo/g, RowNo);
    $('#add_exercise').html('');
    $('#ExerciseInputs').html('');
    Html = Html.replace(/OrderBy/g, OrderBy);
    if(RoutineNo == 1)
        DuplicateRound += Html;
    Html = Html.replace(/RoutineNo/g, RoutineNo);
    Html = Html.replace(/RoundNo/g, RoundNo);
    
    $('#activity'+RoutineNo+'list').append(Html);
    $('.listview').listview();
    $('.listview').listview('refresh');
    $("#benchmark").selectmenu();
    $("#benchmark").selectmenu("refresh");
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

function ExerciseInputs(ExerciseId)
{
     /*
    Returned Values:
    ExerciseId
    ActivityName
    InputFieldName
    Attribute     
    */
   $('#add_exercise').html('');
    $.ajax({url:'ajax.php?module=custom',data:{chosenexercise:ExerciseId,encode:'json'},dataType:"json",success:function(json) { 
        var Html = '<div class="ActivityAttributes">';    
        Html += '<form id="activityform" name="activityform">';
        //var i = document.getElementById('rowcounter').value;
        var RoutineNo = $('#RoutineCounter').val(); 
        var RoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();
        //var OrderBy = $('#Round' + RoundNo + 'Counter').val();
        var Elements = new Array();   
            $.each(json, function() {
                if(this.UOM == null){
                    UOM = '';
                    UOMId = 0;
                }else{
                    UOM = this.UOM;
                    UOMId = this.UOMId;                   
                }
                if(this.Attribute == 'Distance'){ 
                    Elements.push(''+RoutineNo+'_'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_0_'+OrderBy+'');
                    Html += '<div style="float:left;margin:10px 25px 10px 25px">'+this.Attribute+'<br/><input class="textinput" placeholder="'+this.Attribute+'" style="width:50px" type="number" id="'+RoutineNo+'_'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_0_'+OrderBy+'" name="'+RoutineNo+'_'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_0_'+OrderBy+'"/></div>';
                    Elements.push(''+RoutineNo+'_'+RoundNo+'_'+OrderBy+'_'+this.ExerciseId+'_Distance_UOM');
                    Html += '<div style="float:left;margin:10px 25px 10px 25px"><select id="'+RoutineNo+'_'+RoundNo+'_'+OrderBy+'_'+this.ExerciseId+'_Distance_UOM" name="'+RoutineNo+'_'+RoundNo+'_'+OrderBy+'_'+this.ExerciseId+'_Distance_UOM">';
            if('<?php echo $Display->SystemOfMeasure();?>' == 'Metric'){
                Html += '<option value="2">Metres</option>';
                Html += '<option value="1">Kilometres</option>';
                Html += '</select>';               
            }else{
                Html += '<option value="3">Miles</option>';
                Html += '<option value="4">Yards</option>';
                Html += '</select>';                
            } 
            Html += '</div>';
        }else{
                Elements.push(''+RoutineNo+'_'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_'+UOMId+'_'+OrderBy+'');
                Html += '<div style="float:left;margin:10px 25px 10px 25px">'+this.Attribute+'<br/>';
                Html += '<input placeholder="'+this.Attribute+' '+UOM+'" class="textinput" style="width:50px" type="number" id="'+RoutineNo+'_'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_'+UOMId+'_'+OrderBy+'" name="'+RoutineNo+'_'+RoundNo+'_'+this.ExerciseId+'_'+this.Attribute+'_'+UOMId+'_'+OrderBy+'"/>';
                if(this.Attribute == 'Height'){
                    Html += '<input class="textinput" type="hidden" id="'+RoutineNo+'_'+RoundNo+'_'+OrderBy+'_'+this.ExerciseId+'_Height_UOM" name="'+RoutineNo+'_'+RoundNo+'_'+OrderBy+'_'+this.ExerciseId+'_Height_UOM" value="'+UOMId+'"/>';
                    Elements.push(''+RoutineNo+'_'+RoundNo+'_'+OrderBy+'_'+this.ExerciseId+'_Height_UOM');
                }
                Html += '</div>';
               }
            });

            Html += '<div style="float:right;margin:10px 20px 10px 0"><input class="buttongroup" type="button" id="" name="btn" onClick="AddActivity(\''+Elements+'\');" value="Add Activity"/></div>';
            Html += '</div></form><div class="clear"></div>';       

        $('#ExerciseInputs').html(Html);
    }}); 
        $('.buttongroup').button();
        $('.textinput').textinput();
    return false;   
}

function AddActivity(Elements)
{
    var arr = Elements.split(',');
    var Data = '';
    for (var i = 0; i < arr.length; i++) {
        if(i > 0)
            Data += '&';
        Data += arr[i];
        Data += '=';
        Data += $('#'+arr[i]+'').val();
    }

    $.ajax({url:'ajax.php?module=custom&action=formsubmit&thisform=addactivity&'+Data+'',data:"",dataType:"html",success:addactivitydisplay});      
}

function RemoveFromList(ThisItem)
{
    var r=confirm("Remove item?");
    if (r==true)
    {
        var Explode = ThisItem.split('_');
        var RoutineNo = Explode[0];
        var RoundNo = Explode[1];
        var RowNo = Explode[2];
        $('#' + ThisItem + '').remove();
        
        document.getElementById('rowcounter').value--;
        document.getElementById('Routine' + RoutineNo +'Round' + RoundNo + 'Counter').value--;

        if($('#Routine' + RoutineNo +'Round' + RoundNo + 'Counter').val() == 0){
            DuplicateRound = '';
            $('#Routine' + RoutineNo +'Round' + RoundNo + 'Label').html('');
        }
    }
}

function Save()
{
    if($('#rowcounter').val() == 0){
        alert('No Exercises selected!');
    }else{
        /*
        if($('#timerContainer').hasClass('active')){
            $("#TimeToComplete").val($('#clock').html())
        }else{
            $('#timerContainer').html('');
        }
        */
        $.getJSON('ajax.php?module=custom&action=validateform&ValidateInput=no', $("#customform").serialize(),ReturnWorkoutId);
        //$('#HideAfterSave').html('');
        //$('#timerContainer').addClass('active');
        
    }
}

function ReturnWorkoutId(Id)
{
    if(isNaN(Id)){
        alert(Id); 
    }
    else{    
        window.location = "?module=personal&WorkoutTypeId=3&WorkoutId="+Id+"";
     }
}

function addnew(RoundNo, OrderBy)
{
    //var Data = $("#newactivityform").serialize();
    var Data = 'test';
    $.ajax({url:'ajax.php?module=custom&action=formsubmit&RoundNo='+RoundNo+'&OrderBy='+OrderBy+'&'+Data+'',data:"",dataType:"html",success:addactivitydisplay});          
    $.ajax({url:'ajax.php?module=custom',data:{dropdown:'refresh'},dataType:"html",success:dropdownrefresh});  
}

function addRound()
{  
    OrderBy=1;
    var RoutineNo = $('#RoutineCounter').val();
    var PrevRoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();
    var RowNo = $('#rowcounter').val();

    document.getElementById('Routine' + RoutineNo + 'RoundCounter').value++;
    var RoundNo = $('#Routine' + RoutineNo + 'RoundCounter').val();
    var NewRoundCounter = $('#Routine' + RoutineNo +'Round' + PrevRoundNo + 'Counter').val();   
    if(RowNo == 0){
        alert('No Exercises selected!');
    }else if($('#Routine' + RoutineNo + 'Round' + PrevRoundNo + 'Counter').val() == 0){
        alert('No Exercises selected for round ' + PrevRoundNo + '!');
    }else{
        var ThisRound ='<br/><div class="RoundLabel" id="Routine' + RoutineNo + 'Round' + RoundNo + 'Label"><h3>Round ' + RoundNo + '</h3></div>';
        ThisRound +='<input type="hidden" name="Routine' + RoutineNo + 'Round' + RoundNo + 'Counter" id="Routine' + RoutineNo + 'Round' + RoundNo + 'Counter" value="'+NewRoundCounter+'"/>';
        ThisRound+=DuplicateRound.replace(/RoutineNo/g, RoutineNo);
        ThisRound=ThisRound.replace(/RoundNo/g, RoundNo);
        ThisRound=ThisRound.replace(/OrderBy/g, OrderBy);
        ThisRound=ThisRound.replace(/RowNo/g, RowNo);
        ThisRound=ThisRound.replace(/undefined/g, '');

        $(ThisRound).appendTo($('#activity'+RoutineNo+'list'));
        var el = $('#AjaxOutput');
        el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true});        
    }

    $('.textinput').textinput();
    $('.numberinput').textinput();
    $('.listview').listview();
    $('.listview').listview('refresh');    
}

function addRoutine()
{
    OrderBy=0;
    DuplicateRound = '';
    var PrevRoutineNo = $('#RoutineCounter').val();
    var RowNo = $('#rowcounter').val();
    if(RowNo == 0){
        alert('Routine empty!');
    }else if($('#Routine' + PrevRoutineNo + 'Counter').val() == 0){
        alert('No Exercises selected for routine ' + PrevRoutineNo + '!');
    }else{
        document.getElementById('RoutineCounter').value++;
        var RoutineNo = $('#RoutineCounter').val();
        var ThisRoutine ='<div class="clear"></div><div class="RoutineLabel" id="Routine' + RoutineNo + 'Label"><div style="background-color:#EEE" class="RoutineBox"><h3>Routine ' + RoutineNo + '</h3></div>';
        ThisRoutine += '<div class="RoundLabel" id="Routine' + RoutineNo + 'Round1Label"></div>';
        ThisRoutine += '<input type="hidden" name="Routine' + RoutineNo + 'RoundCounter" id="Routine' + RoutineNo + 'RoundCounter" value="1"/>';
        ThisRoutine += '<input type="hidden" name="Routine' + RoutineNo + 'Round1Counter" id="Routine' + RoutineNo + 'Round1Counter" value="0"/>';       
        ThisRoutine += '<div id="activity'+RoutineNo+'list"></div></div>';

        $(ThisRoutine).appendTo($('#Routines'));
    }

    $('.textinput').textinput();
    $('.numberinput').textinput();
    $('.listview').listview();
    $('.listview').listview('refresh');    
}

function clockSelect(type)
{
    if(type == 'select'){
        type = 'stopwatch';
    if($('#timerContainer').hasClass('active'))
        $('#timerContainer').removeClass('active');
    else    
        $('#timerContainer').addClass('active');
    }
    $('#clockType').val(type)
}

function clockControl()
{
    if($('#clockType').val() == 'timer')
        startstopcountdown();
    else if($('#clockType').val() == 'stopwatch')
        startstop();
    else if($('#clockType').val() == 'tabata')
        alert('tabata');
    else
        alert('First choose Clock Type!');
}

function resetControl()
{
    if($('#clockType').val() == 'timer')
        resetcountdown();
    else if($('#clockType').val() == 'stopwatch')
        reset();
    else if($('#clockType').val() == 'tabata')
        alert('tabata');
    else
        alert('First choose Clock Type!');
}

function UpdateActivity(ActivityId, Attributes)
{
    /*
    ActivityId = [RoutineNo_RoundNo_OrderBy_ExerciseId]
     */
    
    var AttributesArray = Attributes.split('_');
    for(i=0; i < AttributesArray.length;i++){
        //alert("#"+ActivityId+"_"+AttributesArray[i]+"_new");
        $("#"+ActivityId+"_"+AttributesArray[i]+"_html").html($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
        $("#"+ActivityId+"_"+AttributesArray[i]+"").val($("#"+ActivityId+"_"+AttributesArray[i]+"_new").val());
    }  
}

function SaveTheseResults(ActivityForm)
{    
    //ActivityForm = RoutineNo_RoundNo_OrderBy_'.$Activity->ExerciseId.'
   var Detail = ActivityForm.split('_');
   var ExerciseId = Detail[3];   
   var TimeToComplete = $('#clock').html();
   var TimeField = ''+Detail[0]+'_'+Detail[1]+'_'+ExerciseId+'_TimeToComplete_0_'+Detail[2]+'';
//1_1_81_Reps_0_1
   $.ajax({url:'ajax.php?module=custom&action=formsubmit&'+TimeField+'='+TimeToComplete+'',data:$('#'+ActivityForm+'').serialize(),dataType:"html",success:messagedisplay});          
   $.ajax({url:'ajax.php?module=custom',data:{history:'refresh', ExerciseId:ExerciseId},dataType:"html",success:function(html) {
        $('#'+ActivityForm+'_History').html(html);   
   }});      
    //'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy)
}
</script>
<br/>

<div id="AjaxOutput">       
    <?php echo $Display->MainOutput();?>
</div>