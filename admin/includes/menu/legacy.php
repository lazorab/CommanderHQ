<?php
    $ratio = $request->get_screen_width_new() / 640;
    $NavIconSize = floor(72*$ratio);
    ?>
<div id="nav" style="height:<?php echo floor(100*$ratio);?>px;background-color:#6e747a">

<?php 
    if(isset($_SESSION['UID'])){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 10%;">
<wall:img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu.png"/>
</div>
<?php }
    
    if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
<wall:a class="menuitem" href="?module=memberhome">
<wall:img alt="Home" <?php echo $RENDER->NewImage('home.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>home.png"/>
</wall:a>
</div>	
<?php } ?>

<div id="menuvideo" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 2% 4%;"></div>

</div>
<div class="clear"></div>