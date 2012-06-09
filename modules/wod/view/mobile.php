<script type="text/javascript">
$(document).ready(function () {
    var curr = new Date().getFullYear();
    var opt = {}
	opt.select = {preset : 'select'};
	opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd/mm/yy', timeFormat: ''  };

    $('#datetime').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));

    $('#selecttype').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
});


function getContent(wodtype, val, width)
{
	$.getJSON("/modules/wod/ajax/getContent.php",{wodtype:wodtype, val:val, width:width},display);
}

function display(data)
{
	document.getElementById("WOD").innerHTML = data;
}

</script>

<h3>Workout of the Day</h3>
    <form id="wodform">
			<label for="selecttype">WOD Type</label>
				<select id="selecttype" name="wodtype" onchange="getContent(this.value, 0, <?php echo $Display->Device->GetScreenWidth();?>);">
					<option value="0">Please Select</option>
					<option value="1">Custom</option>
					<option value="2">My Gym</option>
					<option value="3" <?php if(isset($_REQUEST['benchmark'])){ ?>selected="selected"<?php } ?>>Benchmarks</option>
				</select><br/><br/><br/>
			<label for="datetime">Date</label>
			<input type="text" name="datetime" id="datetime" value="<?php echo date('d/m/Y');?>" onchange="getContent(wodtype.value, 0, <?php echo $Display->Device->GetScreenWidth();?>);/>	
    </form>

<div id="WOD">
	<?php echo $Display->Content($_REQUEST);?>
</div>