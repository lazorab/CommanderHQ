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
	$('#WOD').html(data);
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
<!--
    <form action="index.php" method="post" name="wodform">
	<input type="hidden" name="module" value="wod"/>
				<select id="selecttype" name="wodtype" class="select" onchange="getWOD(this.value);">
					<option value="0">Select WOD Type</option>
					<option value="1" <?php //if($_REQUEST['wodtype'] == 1){ ?>selected="selected"<?php //} ?>>Custom</option>
					<option value="2" <?php //if($_REQUEST['wodtype'] == 2){ ?>selected="selected"<?php //} ?>>My Gym</option>
					<option value="3" <?php //if($_REQUEST['wodtype'] == 3){ ?>selected="selected"<?php //} ?>>Benchmarks</option>
				</select><br/><br/>

			<label for="datetime">Date</label><br/>
			<input type="text" name="datetime" id="datetime" value="<?php echo date('d/m/Y');?>" onchange="getWOD(wodtype.value);/><br/>

    </form>
	-->
</div>
<div id="WOD">
	<?php echo $Display->Output();?>
</div>