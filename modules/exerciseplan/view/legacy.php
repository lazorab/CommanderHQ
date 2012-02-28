<p>
Exercise Planning / Goals
</p>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="module" value="exerciseplan"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
<wall:input type="hidden" name="UID" value="<?php echo $_SESSION['UID'];?>"/>

<?php echo $Display->html();?>

</wall:form>
<wall:br/><wall:br/>