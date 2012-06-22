<?php 
    $ratio = $request->get_screen_width_new() / 640;
    $margin = floor(((640*$ratio) - (422*$ratio)) / 4);
    $GridIconSize = floor(144*$ratio);
    
    ?>

<div id="random"><?php echo $Display->RandomMessage();?></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<wall:a href="?module=wod">
<wall:img alt="WOD" <?php echo $RENDER->NewImage('wodlog.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>wodlog.png"/>
</wall:a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<wall:a href="?module=benchmark">
<wall:img alt="Benchmark" <?php echo $RENDER->NewImage('benchmarks.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>benchmarks.png"/>
</wall:a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<wall:a href="?module=baseline">
<wall:img alt="Baseline" <?php echo $RENDER->NewImage('baseline.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>baseline.png"/>
</wall:a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<wall:a href="?module=challenge">
<wall:img alt="Challenge" <?php echo $RENDER->NewImage('challenges.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>challenges.png"/>
</wall:a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<wall:a href="?module=foodlog">
<wall:img alt="Nutrition" <?php echo $RENDER->NewImage('nutrition.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>nutrition.png"/>
</wall:a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<wall:a href="?module=book">
<wall:img alt="Book" <?php echo $RENDER->NewImage('booking.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>booking.png"/>
</wall:a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<wall:a href="?module=reports">
<wall:img alt="Reports" <?php echo $RENDER->NewImage('reports.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>reports.png"/>
</wall:a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<wall:a href="?module=skills">
<img alt="Skills" <?php echo $RENDER->NewImage('skills.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>skills.png"/>
</wall:a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<wall:a href="?module=products">
<wall:img alt="Store" <?php echo $RENDER->NewImage('store.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>store.png"/>
</wall:a>
</div>
<div class="clear"></div>