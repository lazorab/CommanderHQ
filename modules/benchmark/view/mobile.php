<script type="text/javascript">
$(document).ready(function() {
	//Trigger video
	$("#menuvideo").bind('click', function(){
		//Set vars
		var $VideoTrigger = $('#menuvideo');
		var $Video = $('#video');
                var codes = '<input type="text" size="8" style="margin:4px;color:white;font-weight:bold;background-color:red" value="Weight" readonly="readonly"/>';
    codes += '<input type="text" size="8" style="margin:4px;color:white;font-weight:bold;background-color:blue" value="Height" readonly="readonly"/>';
    codes += '<input type="text" size="8" style="margin:4px;color:white;font-weight:bold;background-color:green" value="Distance" readonly="readonly"/>';
    codes += '<input type="text" size="8" style="margin:4px;color:black;font-weight:bold;background-color:yellow" value="Reps" readonly="readonly"/>';

		//If visible hide else show
		if($Video.hasClass('active')) {
                    
                $('#colorcodes').html(codes);
                
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>video_specific.png"/>');
			
	    	$Video.removeClass('active');
		} else {
                $('#colorcodes').html('');
	    	$VideoTrigger.html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific_active.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>video_specific_active.png"/>');
	    	$Video.addClass('active');
	    }
	});      
});	
    $(function(){
        $('#slides').slides({
            preload: true,
            preloadImage: 'images/ajax-loader.gif',
            generatePagination: true,
            slideSpeed: 500,
            effect: 'slide'
        });
    });
function benchmarksubmit()
{
    $.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
    window.location.hash = '#message';
}

function getBenchmarks(catid)
{
    $.getJSON("ajax.php?module=benchmark",{catid:catid},display);
}

function getDetails(id,origin)
{
    $.getJSON("ajax.php?module=benchmark",{benchmarkId:id, origin:origin},display);
    $.getJSON("ajax.php?module=benchmark",{video:id, benchmarkId:id},videodisplay);
    $.getJSON("ajax.php?module=benchmark",{topselection:id, benchmarkId:id},topselectiondisplay);
    $('#menuvideo').html('<img id="videoselect" alt="Video" <?php echo $RENDER->NewImage('video_specific.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>video_specific.png"/>');
}

function getCustomDetails(id,origin)
{
    $.getJSON("ajax.php?module=benchmark",{customId:id, origin:origin},display);
    $.getJSON("ajax.php?module=benchmark",{topselection:id, customId:id},topselectiondisplay);
}

function topselectiondisplay(data)
{
    var codes = '<input type="text" size="8" style="margin:4px;color:white;font-weight:bold;background-color:red" value="Weight" readonly="readonly"/>';
    codes += '<input type="text" size="8" style="margin:4px;color:white;font-weight:bold;background-color:blue" value="Height" readonly="readonly"/>';
    codes += '<input type="text" size="8" style="margin:4px;color:white;font-weight:bold;background-color:green" value="Distance" readonly="readonly"/>';
    codes += '<input type="text" size="8" style="margin:4px;color:black;font-weight:bold;background-color:yellow" value="Reps" readonly="readonly"/>';
    $('#toplist').html(data);
    $('#toplist').listview('refresh'); 
    $('#colorcodes').html(codes);
}

function videodisplay(data)
{
    $('#video').html(data);
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

function addRound()
{
    //var rounds = document.getElementById('addround').value; 
    $.getJSON('ajax.php?module=benchmark', $("#benchmarkform").serialize(),display);
}
</script>
<br/>

<div id="topselection">
    <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d"></ul>
    <div id="colorcodes"></div>
</div> 

<div id="video"></div>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>