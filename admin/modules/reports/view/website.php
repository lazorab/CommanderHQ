<script type="text/javascript">

function getWods(id)
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{AthleteId:id},dataType:"html",success:display});
}

function display(options)
{
    $('#wod').html(options);
}

</script>

<h1>Reports</h1>

Total registered Athletes:<?php echo $Display->RegisteredAthleteCount();?>
<br/>
<br/>
<form action="index.php" name="reports">
    <input type="hidden" name="module" value="reports"/>
<input type="submit" name="report" value="Registered Athletes"/>
<br/>
<br/>
<input type="submit" name="report" value="WOD Results"/>
<br/>
<br/>    
    <?php echo $Display->RegisteredAthletes();?>
<br/>
<br/>
<select name="wod" id="wod"><option value="">Completed Wods</option></select>

</form>