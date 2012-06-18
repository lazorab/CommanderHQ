<script type="text/javascript">
$(document).ready(function () {
                  var curr = new Date().getFullYear();
                  var opt = {}
                  opt.select = {preset : 'select'};
                  opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd/mm/yy', timeFormat: ''  };
                  
                  $('#datetime').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));
                  
                  $('#action').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
});


function getOptions(action,date)
{
    $.getJSON("ajax.php?module=reports",{action:action, date:date},display);
}

function getWODReport(id,date)
{
    $.getJSON("ajax.php?module=reports",{WODId:id, date:date},display);
}

function getBenchmarkReport(id,date)
{
    $.getJSON("ajax.php?module=reports",{BenchmarkId:id, date:date},display);
}

function getBaselineReport(id,date)
{
    $.getJSON("ajax.php?module=reports",{BaselineId:id, date:date},display);
}

function display(data)
{
	document.getElementById("reportdata").innerHTML = data;
}

</script>
<br/>
<h3>Reports</h3>
<form id="reportform" name="reportform">
<label for="action">Report Type</label>
<select id="action" name="action" onchange="getOptions(this.value, datetime.value);">
<option value="">Please Select</option>
<option value="Benchmarks">Benchmarks</option>
<option value="Baseline">Baseline</option>
<option value="WOD">WOD</option>
<option value="Pending">Pending Exercises</option>
<option value="Weight">Weight History</option>
</select><br/><br/><br/>
<label for="datetime">Date</label>
<input type="text" name="datetime" id="datetime" value="<?php echo date('d/m/Y');?>" onchange="getOptions(action.value, this.value);"/>	
</form>

<div id="reportdata">
<?php echo $Display->Output();?>
</div>

<br/><br/>
Current Skills Level:<?php echo $Display->MemberDetails->SkillLevel; ?>
<br/><br/>