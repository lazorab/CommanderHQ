<?php 
$ratio = $request->get_screen_width_new() / 500;
$margin = floor(((500*$ratio) - (276*$ratio)) / 4);
$GridIconSize = floor(92*$ratio);?>

<div id="random"><?php echo $Display->RandomMessage();?></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=wod">
<img alt="WOD" src="<?php echo $RENDER->Image('wodlog.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=benchmark">
<img alt="Benchmark" src="<?php echo $RENDER->Image('benchmarks.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=baseline">
<img alt="Baseline" src="<?php echo $RENDER->Image('baseline.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=challenge">
<img alt="Challenge" src="<?php echo $RENDER->Image('challenges.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=foodlog">
<img alt="Nutrition" src="<?php echo $RENDER->Image('nutrition.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px 0px <?php echo $margin;?>px;">
<a href="?module=book">
<img alt="Book" src="<?php echo $RENDER->Image('booking.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="clear"></div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=reports">
<img alt="Reports" src="<?php echo $RENDER->Image('reports.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=skills">
<img alt="Skills" src="<?php echo $RENDER->Image('skills.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="grid" style="float:left;width:<?php echo $GridIconSize;?>px;height:<?php echo $GridIconSize;?>px;margin:<?php echo $margin;?>px 0px <?php echo $margin;?>px <?php echo $margin;?>px;">
<a href="?module=products">
<img alt="Store" src="<?php echo $RENDER->Image('store.png', $request->get_screen_width_new());?>"/>
</a>
</div>
<div class="clear"></div>