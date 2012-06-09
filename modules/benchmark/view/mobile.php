<script type="text/javascript">
$(document).ready(function() {
	//Trigger video
	$("img#videoselect").bind('click', function(){
		//Set vars
		var $VideoTrigger = $('img#videoselect');
		var $Video = $('#video');

		//If visible hide else show
		if($Video.hasClass('active')) {
	    	$VideoTrigger.attr("src", '<?php echo $RENDER->Image('video_specific.png', $request->get_screen_width_new());?>');
	    	$Video.removeClass('active');
		} else {
	    	$VideoTrigger.attr("src",'<?php echo $RENDER->Image('video_specific_active.png', $request->get_screen_width_new());?>');
	    	$Video.addClass('active');
	    }
	});
	
	$.getJSON("ajax.php",{catid:catid, id:id),display);
	
});	

function display(data)
{
	document.getElementById("Benchmark").innerHTML = data;
}

    function GetVideo(filename)
    {
		document.getElementById("videobutton").src = '<?php echo $RENDER->Image('video_specific_active.png', $device->GetScreenWidth());?>';
        document.getElementById("video").innerHTML = '<iframe marginwidth="0px" marginheight="0px" width="<?php echo $device->GetScreenWidth();?>" height="<?php echo floor($device->GetScreenWidth() * 0.717);?>" src="' + filename + '" frameborder="0"><\/iframe>';
    }
</script>
<div id="content">
<div id="video">
<iframe marginwidth="0px" marginheight="0px" width="<?php echo $device->GetScreenWidth();?>" height="<?php echo floor($device->GetScreenWidth() * 0.717);?>" src="http://www.youtube.com/embed/<?php echo $_REQUEST['video'];?>" frameborder="0">
</iframe>
</div>
<div id="Benchmark">
<?php echo $Display->Output();?>
</div>
</div>