<?php echo $Display->Message();?>

<form action="index.php" method="post">
<input type="hidden" name="module" value="exerciselog"/>
<input type="hidden" name="formsubmitted" value="yes"/>
<input type="hidden" name="UID" value="<?php echo $_COOKIE['UID'];?>"/>

<?php echo $Display->Html();?>

</form>