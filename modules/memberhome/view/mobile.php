<?php 
$ratio = $request->get_screen_width_new() / 640;
$margin = floor(((640*$ratio) - (422*$ratio)) / 4);
$GridIconSize = floor(144*$ratio);
?>

<div id="random"><?php echo $Display->RandomMessage();?></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=wod">
<img alt="WOD" <?php echo $RENDER->NewImage('wodlog.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>wodlog.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=benchmark">
<img alt="Benchmark" <?php echo $RENDER->NewImage('benchmarks.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>benchmarks.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=baseline">
<img alt="Baseline" <?php echo $RENDER->NewImage('baseline.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>baseline.png"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=challenge">
<img alt="Challenge" <?php echo $RENDER->NewImage('challenges.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>challenges.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=foodlog">
<img alt="Nutrition" <?php echo $RENDER->NewImage('nutrition.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>nutrition.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=book">
<img alt="Book" <?php echo $RENDER->NewImage('booking.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>booking.png"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=reports">
<img alt="Reports" <?php echo $RENDER->NewImage('reports.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>reports.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=skills">
<img alt="Skills" <?php echo $RENDER->NewImage('skills.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>skills.png"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=products">
<img alt="Store" <?php echo $RENDER->NewImage('store.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>store.png"/>
</a>
</div>
<div class="clear"></div>