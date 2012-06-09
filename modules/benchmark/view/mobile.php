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
    var html = '<img id="videoselect" alt="Video" src="<?php echo $RENDER->Image('video_specific.png', $request->get_screen_width_new());?>"/>';
    document.getElementById("menuvideo").innerHTML = html;
}

function display(data)
{
	document.getElementById("Benchmark").innerHTML = data;
}

</script>
<div id="content">
    <div id="Benchmark">
        <?php echo $Display->Output();?>
    </div>
</div>