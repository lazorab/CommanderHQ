<script type="application/javascript" src="/js/add2home.js"></script>

<?php 
$ratio = SCREENWIDTH / 640;
$margin = floor(((640*$ratio) - (435*$ratio)) / 4);
$GridIconSize = floor(145*$ratio);
?>

<div id="random"><?php echo $Display->RandomMessage();?></div>

<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('index.php?module=wod');">
<img alt="WOD" <?php echo $RENDER->NewImage('wodlog.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>wodlog.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=benchmark');">
<img alt="Benchmark" <?php echo $RENDER->NewImage('benchmarks.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>benchmarks.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="#" onclick="OpenThisPage('?module=baseline');">
<img alt="Baseline" <?php echo $RENDER->NewImage('baseline.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>baseline.png"/>
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