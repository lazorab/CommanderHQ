<script type="text/javascript">

function getWOD(wodtype)
{
	$.getJSON("ajax.php?module=wod",{wodtype:wodtype},display);		
}

function getBenchmark(id)
{
    $.getJSON("ajax.php?module=wod",{benchmark:id},display);
}

function getCustomContent(customid)
{
    $.getJSON("ajax.php?module=wod",{customid:customid},display);
}

function getCustomExercise(id)
{
    $.getJSON("ajax.php?module=wod",{customexercise:id, wodtype:1},display);
}

function display(data)
{
	$('#AjaxOutput').html(data);
	$('#listview').listview();
	$('#listview').listview('refresh');
	$("input").checkboxradio ();
	$("input").closest ("div:jqmData(role=controlgroup)").controlgroup ();
}
</script>
<br/>
<div id="topselection">
		<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li><a href="" onclick="getWOD('1');">Custom</a></li>
					<li><a href="" onclick="getWOD('2');">My Gym</a></li>
					<li><a href="" onclick="getWOD('3');">Benchmarks</a></li>	
				</ul>
</div>
<div id="AjaxOutput">
	<?php echo $Display->Output();?>
</div>