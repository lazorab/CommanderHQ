<?php
$DropDown = new DropDownMenu;
?>
<h3>Challenges</h3>
Choose your challenge<wall:br/>
<wall:select name="challenge">
<?php echo $DropDown->Challenges($_REQUEST['challenge']);?>
</wall:select><wall:br/>