<?php 
$ratio = SCREENWIDTH / 640;
$margin = floor(((640*$ratio) - (400*$ratio)) / 4);
$GridIconSize = floor(132*$ratio);

echo $Display->FirstTimeMessage();

?>

<div id="random"><?php echo $Display->Message();?></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('index.php?module=wod');">
<img alt="WOD" <?php echo $RENDER->NewImage('wod.png');?> src="<?php echo IMAGE_RENDER_PATH;?>wod.png"/><br />
<div class="tagIcon">WOD</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=nutrition');">
<img alt="Nutrition" <?php echo $RENDER->NewImage('nutrition.png');?> src="<?php echo IMAGE_RENDER_PATH;?>nutrition.png"/><br />
<div class="tagIcon">Nutrition</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=reports');">
<img alt="Reports" <?php echo $RENDER->NewImage('reports.png');?> src="<?php echo IMAGE_RENDER_PATH;?>reports.png"/><br />
<div class="tagIcon">Progress</div>
</a>
</div>

<div class="clear"></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=challenge');">
<img alt="Challenge" <?php echo $RENDER->NewImage('challenges.png');?> src="<?php echo IMAGE_RENDER_PATH;?>challenges.png"/><br />
<div class="tagIcon">Challenges</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=products');">
<img alt="Store" <?php echo $RENDER->NewImage('store.png');?> src="<?php echo IMAGE_RENDER_PATH;?>store.png"/><br />
<div class="tagIcon">Store</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=skills');">
<img alt="Skills" <?php echo $RENDER->NewImage('skills.png');?> src="<?php echo IMAGE_RENDER_PATH;?>skills.png"/><br />
<div class="tagIcon">Skills Level</div>
</a>
</div>

<div class="clear"></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=book');">
<img alt="Book" <?php echo $RENDER->NewImage('booking.png');?> src="<?php echo IMAGE_RENDER_PATH;?>booking.png"/><br />
<div class="tagIcon">Booking</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=locator');">
<img alt="Affiliates" <?php echo $RENDER->NewImage('affiliates.png');?> src="<?php echo IMAGE_RENDER_PATH;?>affiliates.png"/><br />
<div class="tagIcon">Affiliates</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=aboutcrossfit');">
<img alt="About" <?php echo $RENDER->NewImage('crossfit.png');?> src="<?php echo IMAGE_RENDER_PATH;?>crossfit.png"/><br />
<div class="tagIcon">CrossFit</div>
</a>
</div>

<div class="clear"></div>