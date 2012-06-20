<?php echo $Display->Message();?>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="module" value="exerciselog"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
<wall:input type="hidden" name="UID" value="<?php echo $_SESSION['UID'];?>"/>

<?php echo $Display->Html();?>

</wall:form>