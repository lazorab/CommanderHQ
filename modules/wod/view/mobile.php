<script type="text/javascript">
$(document).ready(function () {
    var curr = new Date().getFullYear();
    var opt = {}
	opt.select = {preset : 'select'};
	opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd/mm/yy', timeFormat: ''  };

    $('#datetime').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));

    $('#selecttype').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
	
	$("#customselect").scroller($.extend(opt["select"], { theme: "default", mode: "scroller", display: "model" }));
});


function getWOD(wodtype)
{
	if(wodtype==1)
		document.wodform.submit();
	else
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

function display(data)
{
	document.getElementById("WOD").innerHTML = data;
}

</script>

<h3>Workout of the Day</h3>
    <form action="index.php" method="post" name="wodform">
	<input type="hidden" name="module" value="wod"/>
			<label for="selecttype">WOD Type</label>
				<select id="selecttype" name="wodtype" onchange="getWOD(this.value);">
					<option value="0">Please Select</option>
					<option value="1" <?php if($_REQUEST['wodtype'] == 1){ ?>selected="selected"<?php } ?>>Custom</option>
					<option value="2" <?php if($_REQUEST['wodtype'] == 2){ ?>selected="selected"<?php } ?>>My Gym</option>
					<option value="3" <?php if($_REQUEST['wodtype'] == 3){ ?>selected="selected"<?php } ?>>Benchmarks</option>
				</select><br/><br/><br/>
			<label for="datetime">Date</label>
			<input type="text" name="datetime" id="datetime" value="<?php echo date('d/m/Y');?>" onchange="getWOD(wodtype.value);/>	
    </form>

<div id="WOD">
	<?php echo $Display->Output();?>
</div>