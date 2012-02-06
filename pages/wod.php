<?php
$Action = new WOD;
$WOD = $Action->getWOD();
?>
<h3>Workout of the Day</h3>
<?php echo date('l jS \of F Y');?>
<p><?php echo $WOD->ActivityName;?></p>
<p><?php echo $WOD->Description;?></p>