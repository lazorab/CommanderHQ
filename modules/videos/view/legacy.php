<wall:br/><wall:br/>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="module" value="videos"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
Search for videos<wall:br/>
<wall:input type="text" name="keyword" value="<?php echo $_REQUEST['keyword'];?>"/>
<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
</wall:form>

<?php echo $Display->Html();?>