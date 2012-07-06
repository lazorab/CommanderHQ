<script type="text/javascript">	

function getExercise(exerciseid)
{
    $.getJSON("ajax.php?module=skills",{exercise:exerciseid},display);
}

function display(data)
{
	document.getElementById("Skills").innerHTML = data;
}

</script>

<div id="content">
<br/>
<h3>Skills</h3>
<br/>
<form name="skillsform" id="skillsform" action="index.php" method="post">
<input type="hidden" name="module" value="skills"/>
<select id="exerciseselect" name="exercise" class="select" onchange="getExercise(this.value);">
<option value="">Select Exercise</option>
<?php
$Selected = '';
$Exercises = $Display->getExercises();
foreach($Exercises as $Exercise){
    if($_REQUEST['exercise'] == $Exercise->Id)
        $Selected =' selected="selected"'; ?>
    <option value="<?php echo $Exercise->Id;?>"<?php echo $Selected;?>><?php echo $Exercise->Exercise; ?></option>
<?php } ?>
</select><br/>
</form>
<br/>
<br/>
<div id="Skills">
<?php echo $Display->Output();?>
</div>
</div>