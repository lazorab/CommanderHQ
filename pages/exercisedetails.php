<?php
$id = $_REQUEST['id'];
$Exercise = new Exercise();
$Detail=$Exercise->getExercise($id);
?>
<wall:br/>
<h3><?php echo $Detail->Exercise?></h3>
<h3>Level 1 Requirements</h3>
<?php if($Detail->SK1Weight > 0) { ?>
	<wall:br/>Weight: <?php echo $Detail->SK1Weight;?> kg
	<?php } ?>
<?php if($Detail->SK1Height != '') { ?>
	<wall:br/>Height: <?php echo $Detail->SK1Height;?> meters
	<?php } ?>
<?php if($Detail->SK1Duration != '') { ?>
	<wall:br/>Duration: <?php echo $Detail->SK1Duration;?>
	<?php } ?>	
<?php if($Detail->SK1Reps != '') { ?>
	<wall:br/>Reps: <?php echo $Detail->SK1Reps;?>
	<?php } ?>	
<?php if($Detail->SK1Description != '') { ?>
	<wall:br/>( <?php echo $Detail->SK1Description;?> )
	<?php } ?>	
<wall:br/><wall:br/>	
<h3>Level 2 Requirements</h3>
<?php if($Detail->SK2Weight > 0) { ?>
	<wall:br/>Weight: <?php echo $Detail->SK2Weight;?> kg
	<?php } ?>
<?php if($Detail->SK2Height != '') { ?>
	<wall:br/>Height: <?php echo $Detail->SK2Height;?> meters
	<?php } ?>
<?php if($Detail->SK2Duration != '') { ?>
	<wall:br/>Duration: <?php echo $Detail->SK2Duration;?>
	<?php } ?>	
<?php if($Detail->SK2Reps != '') { ?>
	<wall:br/>Reps: <?php echo $Detail->SK2Reps;?>
	<?php } ?>	
<?php if($Detail->SK2Description != '') { ?>
	<wall:br/>( <?php echo $Detail->SK2Description;?> )
	<?php } ?>	
<wall:br/><wall:br/>		
<h3>Level 3 Requirements</h3>
<?php if($Detail->SK3Weight > 0) { ?>
	<wall:br/>Weight: <?php echo $Detail->SK3Weight;?> kg
	<?php } ?>
<?php if($Detail->SK3Height != '') { ?>
	<wall:br/>Height: <?php echo $Detail->SK3Height;?> meters
	<?php } ?>
<?php if($Detail->SK3Duration != '') { ?>
	<wall:br/>Duration: <?php echo $Detail->SK3Duration;?>
	<?php } ?>	
<?php if($Detail->SK3Reps != '') { ?>
	<wall:br/>Reps: <?php echo $Detail->SK3Reps;?>
	<?php } ?>	
<?php if($Detail->SK3Description != '') { ?>
	<wall:br/>( <?php echo $Detail->SK3Description;?> )
	<?php } ?>	
<wall:br/><wall:br/>	
<h3>Level 4 Requirements</h3>
<?php if($Detail->SK4Weight > 0) { ?>
	<wall:br/>Weight: <?php echo $Detail->SK4Weight;?> kg
	<?php } ?>
<?php if($Detail->SK4Height != '') { ?>
	<wall:br/>Height: <?php echo $Detail->SK4Height;?> meters
	<?php } ?>
<?php if($Detail->SK4Duration != '') { ?>
	<wall:br/>Duration: <?php echo $Detail->SK4Duration;?>
	<?php } ?>	
<?php if($Detail->SK4Reps != '') { ?>
	<wall:br/>Reps: <?php echo $Detail->SK4Reps;?>
	<?php } ?>	
<?php if($Detail->SK4Description != '') { ?>
	<wall:br/>( <?php echo $Detail->SK4Description;?> )
	<?php } ?>		