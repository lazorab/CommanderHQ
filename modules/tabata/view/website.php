<?php echo $Display->Message();?>

<form action="index.php" method="post">
<input type="hidden" name="module" value="tabata"/>
<input type="hidden" name="formsubmitted" value="yes"/>
<input type="hidden" name="UID" value="<?php echo $_SESSION['UID'];?>"/>

<?php echo $Display->Html();?>

</form>