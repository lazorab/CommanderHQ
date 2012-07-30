<script type="text/javascript">
$(document).ready(function() {
	//Trigger video
	$("#menuvideo").bind('click', function(){
		//Set vars
		var $VideoTrigger = $('#menuvideo');
		var $Video = $('#video');

		//If visible hide else show
		if($Video.hasClass('active')) {
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" src="<?php echo $RENDER->Image('video_specific.png', $request->get_screen_width_new());?>"/>');
	    	$Video.removeClass('active');
		} else {
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" src="<?php echo $RENDER->Image('video_specific_active.png', $request->get_screen_width_new());?>"/>');
	    	$Video.addClass('active');
	    }
	});
});	

function getBenchmarks(catid)
{
    $.getJSON("ajax.php?module=benchmark",{catid:catid},display);
}

function getDetails(id)
{
    $.getJSON("ajax.php?module=benchmark",{id:id},display);
	$('#menuvideo').html('<img id="videoselect" alt="Video" src="<?php echo $RENDER->Image('video_specific.png', $request->get_screen_width_new());?>"/>');
}

function display(data)
{
	$('#AjaxOutput').html(data);
	$('#listview').listview();
	$('#listview').listview('refresh');
	$('.controlbutton').button();
	$('.controlbutton').button('refresh');
	$('.buttongroup').button();
	$('.buttongroup').button('refresh');
	$('#AjaxLoading').html('');	
}

</script>
<br/>
<div id="topselection">
    <?php echo $Display->BenchmarkSelection();?>
</div>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>