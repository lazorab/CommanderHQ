<script type="text/javascript">

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
<select id="action" name="action" class="select" onchange="getOptions(this.value, datetime.value);">
<option value="">Select Report</option>
<option value="Benchmarks">Benchmarks</option>
<option value="Baseline">Baseline</option>
<option value="WOD">WOD</option>
<option value="Pending">Pending Exercises</option>
<option value="Weight">Weight History</option>
</select><br/><br/>

<input type="date" name="datetime" id="datetime" value="<?php echo date('d M Y');?>"/><br/>

</form>
</div>

<div id="reportdata">
<?php echo $Display->Output();?>
Current Skills Level:<?php echo $Display->MemberDetails->SkillLevel; ?>
</div>
