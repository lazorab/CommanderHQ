<?php 
$ratio = SCREENWIDTH / 640;
$margin = floor(((640*$ratio) - (480*$ratio)) / 4);
$GridIconSize = floor(154*$ratio);

echo $Display->FirstTimeMessage();

?>

<div id="random"><?php echo $Display->Message();?></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('index.php?module=wod');">
<img class="Aicon" alt="WOD" <?php echo $RENDER->NewImage('wod.png');?> src="<?php echo IMAGE_RENDER_PATH;?>wod.png"/><br />
<div class="tagIcon">WOD</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">

<img class="Aicon" alt="Nutrition" <?php echo $RENDER->NewImage('nutrition.png');?> src="<?php echo IMAGE_RENDER_PATH;?>nutrition.png"/><br />
<div class="tagIcon">Nutrition</div>

</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=reports');">
<img class="Aicon" alt="Reports" <?php echo $RENDER->NewImage('reports.png');?> src="<?php echo IMAGE_RENDER_PATH;?>reports.png"/><br />
<div class="tagIcon">Progress</div>
</a>
</div>

<div class="clear"></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">

<img class="Aicon" alt="Challenge" <?php echo $RENDER->NewImage('challenges.png');?> src="<?php echo IMAGE_RENDER_PATH;?>challenges.png"/><br />
<div class="tagIcon">Challenges</div>

</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">

<img class="Aicon" alt="Store" <?php echo $RENDER->NewImage('store.png');?> src="<?php echo IMAGE_RENDER_PATH;?>store.png"/><br />
<div class="tagIcon">Store</div>

</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=skills');">
<img class="Aicon" alt="Skills" <?php echo $RENDER->NewImage('skills.png');?> src="<?php echo IMAGE_RENDER_PATH;?>skills.png"/><br />
<div class="tagIcon">Skills Level</div>
</a>
</div>

<div class="clear"></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">

<img class="Aicon" alt="Book" <?php echo $RENDER->NewImage('booking.png');?> src="<?php echo IMAGE_RENDER_PATH;?>booking.png"/><br />
<div class="tagIcon">Booking</div>

</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=locator');">
<img class="Aicon" alt="Affiliates" <?php echo $RENDER->NewImage('affiliates.png');?> src="<?php echo IMAGE_RENDER_PATH;?>affiliates.png"/><br />
<div class="tagIcon">Affiliates</div>
</a>
</div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=about');">
<img class="Aicon" alt="About" <?php echo $RENDER->NewImage('crossfit.png');?> src="<?php echo IMAGE_RENDER_PATH;?>crossfit.png"/><br />
<div class="tagIcon">CrossFit</div>
</a>
</div>

<div class="clear"></div>