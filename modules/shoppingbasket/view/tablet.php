<?php echo $Display->ShoppingBasket();?>
<form action="index.php" method="post">
<input type="hidden" name="module" value="shoppingbasket"/>
<input type="hidden" name="form" value="submitted"/>
<input type="submit" name="action" value="Check Out"/>
<br/>
<input type="submit" name="action" value="Back to Products"/>
</form>