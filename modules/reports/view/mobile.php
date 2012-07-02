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
<div id="topselection">
<form id="reportform" name="reportform">
<select id="action" name="action" onchange="getOptions(this.value, datetime.value);">
<option value="">Select Report</option>
<option value="Benchmarks">Benchmarks</option>
<option value="Baseline">Baseline</option>
<option value="WOD">WOD</option>
<option value="Pending">Pending Exercises</option>
<option value="Weight">Weight History</option>
</select><br/><br/>

<input type="text" name="datetime" id="datetime" value="<?php echo date('d/m/Y');?>" onchange="getWOD(wodtype.value);/><br/>

</form>
</div>

<div id="reportdata">
<?php echo $Display->Output();?>
Current Skills Level:<?php echo $Display->MemberDetails->SkillLevel; ?>
</div>
