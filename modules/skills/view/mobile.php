<script type="text/javascript">	

function getExercise(exercise)
{
    $.getJSON("ajax.php?module=skills",{exercise:exercise},display);
}

function display(data)
{
	document.getElementById("Skills").innerHTML = data;
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('#exercise').selectmenu();
    $('#exercise').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();	
}

</script>

<div id="content">
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
    <option value="<?php echo $Exercise->Exercise;?>"<?php echo $Selected;?>><?php echo $Exercise->Exercise; ?></option>
<?php } ?>
</select><br/>
</form>
<br/>
<div id="Skills">
<?php echo $Display->Output();?>
</div>
</div>