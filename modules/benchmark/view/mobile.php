<script type="text/javascript">
$(document).ready(function() {
	//Trigger video
	$("#menuvideo").bind('click', function(){
		//Set vars
		var $VideoTrigger = $('#menuvideo');
		var $Video = $('#video');

		//If visible hide else show
		if($Video.hasClass('active')) {
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>video_specific.png"/>');
			
	    	$Video.removeClass('active');
		} else {
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific_active.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>video_specific_active.png"/>');
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
	$('#menuvideo').html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>video_specific.png"/>');
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