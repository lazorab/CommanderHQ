<?php echo $Display->getMessage();?>
<form action="index.php" method="post">
<input type="hidden" name="module" value="products"/>
<input type="hidden" name="form" value="submitted"/>

<?php echo $Display->getHtml();?>

</form>