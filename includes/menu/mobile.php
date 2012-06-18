<?php
$ratio = $request->get_screen_width_new() / 500;
$NavIconSize = floor(58*$ratio);
?>
<div id="nav" style="height:<?php echo floor(82*$ratio);?>px;background-image:url(<?php echo $RENDER->Image('navbar.png', $request->get_screen_width_new());?>);">

<?php 
if(isset($_SESSION['UID'])){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 10%;">
	<img id="menuselect" alt="Menu" src="<?php echo $RENDER->Image('menu.png', $request->get_screen_width_new());?>"/>
</div>
<?php }
    
if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<a class="menuitem" href="?module=memberhome"><img alt="Home" src="<?php echo $RENDER->Image('home.png', $request->get_screen_width_new());?>"/></a>
</div>	
<?php } ?>

<div id="menuvideo" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 2% 4%;"></div>

</div>
<div class="clear"></div>