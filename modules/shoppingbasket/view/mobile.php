<?php echo $Display->ShoppingBasket();?>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="module" value="shoppingbasket"/>
<wall:input type="hidden" name="form" value="submitted"/>
<wall:input type="submit" name="action" value="Check Out"/>
<wall:br/>
<wall:input type="submit" name="action" value="Back to Products"/>
</wall:form>