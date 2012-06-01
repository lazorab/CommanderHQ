<?php 
$ratio = $request->get_screen_width_new() / 500;
$margin = floor(((500*$ratio) - (324*$ratio)) / 4);
$GridIconSize = floor(108*$ratio);?>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=wod" data-transition="slide">
<img alt="WOD" src="<?php echo $RENDER->Image('wodlog.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=benchmark" data-transition="slide">
<img alt="Benchmark" src="<?php echo $RENDER->Image('benchmarks.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=baseline" data-transition="slide">
<img alt="Baseline" src="<?php echo $RENDER->Image('baseline.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=challenge" data-transition="slide">
<img alt="Challenge" src="<?php echo $RENDER->Image('challenges.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=foodlog" data-transition="slide">
<img alt="Nutrition" src="<?php echo $RENDER->Image('nutrition.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=book"  data-transition="slide">
<img alt="Book" src="<?php echo $RENDER->Image('booking.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=reports" data-transition="slide">
<img alt="Reports" src="<?php echo $RENDER->Image('reports.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=skills" data-transition="slide">
<img alt="Skills" src="<?php echo $RENDER->Image('skills.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=videos" data-transition="slide">
<img alt="Videos" src="<?php echo $RENDER->Image('videos.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="clear"></div>