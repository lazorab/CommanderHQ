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

function topselectiondisplay(data)
{
    $('#toplist').html(data);
    $('#toplist').listview('refresh');   
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
<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
<?php if($_REQUEST['catid'] == '1'){ ?>
	<li>The Girls</li>			
<?php }else if($_REQUEST['catid'] == '2'){ ?>
	<li>The Heros</li>
<?php }else if($_REQUEST['catid'] == '3'){ ?>
        <li>Travel</li>
<?php }else if($_REQUEST['catid'] == '4'){ ?>
	<li>Historic</li>		
<?php } else { ?>
    <li><a href="#" onclick="OpenThisPage('?module=benchmark&catid=1&origin=<?php echo $_REQUEST['origin'];?>')">The Girls</a></li>
    <li><a href="#" onclick="OpenThisPage('?module=benchmark&catid=2&origin=<?php echo $_REQUEST['origin'];?>')">The Heros</a></li>
    <li><a href="#" onclick="OpenThisPage('?module=benchmark&catid=3&origin=<?php echo $_REQUEST['origin'];?>')">Travel</a></li>
    <li><a href="#" onclick="OpenThisPage('?module=benchmark&catid=4&origin=<?php echo $_REQUEST['origin'];?>')">Historic</a></li>
<?php } ?>
</ul>
</div> 

<br/>

<div id="video"></div>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>