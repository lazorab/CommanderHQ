<?php 
$ratio = SCREENWIDTH / 640;
$margin = floor(((640*$ratio) - (435*$ratio)) / 4);
$GridIconSize = floor(145*$ratio);

echo $Display->FirstTimeMessage();

?>

<div id="random"><?php echo $Display->RandomMessage();?></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('index.php?module=wod');">
<img alt="WOD" <?php echo $RENDER->NewImage('wod.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>wod.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=locator');">
<img alt="Affiliates" <?php echo $RENDER->NewImage('affiliates.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>affiliates.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=aboutcrossfit');">
<img alt="About" <?php echo $RENDER->NewImage('crossfit.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>crossfit.png"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=challenge');">
<img alt="Challenge" <?php echo $RENDER->NewImage('challenges.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>challenges.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=foodlog');">
<img alt="Nutrition" <?php echo $RENDER->NewImage('nutrition.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>nutrition.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=book');">
<img alt="Book" <?php echo $RENDER->NewImage('booking.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>booking.png"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=reports');">
<img alt="Reports" <?php echo $RENDER->NewImage('reports.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>reports.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=skills');">
<img alt="Skills" <?php echo $RENDER->NewImage('skills.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>skills.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=products');">
<img alt="Store" <?php echo $RENDER->NewImage('store.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>store.png"/>
</a>
</div>
<div class="clear"></div>