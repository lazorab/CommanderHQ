<script type="text/javascript">
$(document).ready(function () {
    var curr = new Date().getFullYear();
    var opt = {}
    opt.select = {preset : 'select'};
    opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd/mm/yy', timeFormat: ''  };
                  
    $('#datetime').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));
                  
    $('#action').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
	
	$("#dateselect").scroller($.extend(opt["datetime"], { theme: "default", mode: "scroller", display: "model" }));
});

function getContent(action)
{
    $.getJSON("ajax.php?module=goals",{action:action},display);
}

function getBenchmark(id)
{
    $.getJSON("ajax.php?module=goals",{benchmark:id},display);
}

function display(data)
{
	document.getElementById("goal").innerHTML = data;
}

</script>

<h3>Goals</h3>
<form id="goalform">
<label for="action">Action</label>
<select id="action" name="action" onchange="getContent(this.value);">
<option value="">Please Select</option>
<option value="new" <?php if($_REQUEST['action'] == 'new'){echo 'selected="selected"';};?>>New Goal</option>
<option value="active" <?php if($_REQUEST['action'] == 'active'){echo 'selected="selected"';};?>>Active</option>
<option value="achieved" <?php if($_REQUEST['action'] == 'achieved'){echo 'selected="selected"';};?>>Achieved</option>
<option value="failed" <?php if($_REQUEST['action'] == 'failed'){echo 'selected="selected"';};?>>Failed</option>
</select><br/><br/><br/>
<label for="datetime">Date</label>
<input type="text" name="datetime" id="datetime" value="<?php echo date('d/m/Y');?>" onchange="getContent(action.value);"/>	
</form>

<div id="goal">
<?php echo $Display->Output();?>
</div>