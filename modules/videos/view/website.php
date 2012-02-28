<br/><br/>
<form action="index.php" method="post">
<input type="hidden" name="module" value="videos"/>
<input type="hidden" name="formsubmitted" value="yes"/>
Search for videos<br/>
<input type="text" name="keyword" value="<?php echo $_REQUEST['keyword'];?>"/>
<input type="submit" name="submit" value="Submit"/><br/><br/>
</form>

<?php echo $Display->Html();?>