<?php
session_start();
$Report=new Reports($_SESSION['UID']);
$Details=$Report->getDetails();
$PendingExercises=$Report->getPendingExercises();
?>
<wall:br/><wall:br/>
Current Skills Level:<?php echo $Details->SkillLevel; ?>
<wall:br/><wall:br/>
Pending Skill Exercises:
<?php foreach($PendingExercises AS $Exercise) { ?>
	<wall:br/><wall:a href="index.php?page=exercisedetails&amp;id=<?php echo $Exercise->Id; ?>"><?php echo $Exercise->Exercise; ?></wall:a>
<?php } ?>