
<?php
$ratio = $request->get_screen_width_new() / 640;
$NavIconSize = floor(72*$ratio);
?>
<div id="nav" style="height:<?php echo floor(100*$ratio);?>px;">

<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 10%;">
	<img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu.png"/>
</div>
    
<?php if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<a class="menuitem" href="?module=memberhome" data-ajax="false" data-transition="slidefade" data-prefetch><img alt="Home" <?php echo $RENDER->NewImage('home.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>home.png"/></a>
</div>	
<?php } ?>

<div id="menuvideo" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 2% 4%;"></div>

<div id="menu" data-role="menu">

<a href="?module=products" data-ajax="false" data-prefetch>
<img alt="Store" <?php echo $RENDER->NewImage('menu_store.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_store.png"/>
</a>

    <img alt="Personal" <?php echo $RENDER->NewImage('menu_personal.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_personal.png"/>

<a href="?module=register" data-ajax="false" data-prefetch>
    <img alt="Register" <?php echo $RENDER->NewImage('menu_register_gym.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_register_gym.png"/></a>

<a href="?module=goals" data-ajax="false" data-prefetch>
    <img alt="Goals" <?php echo $RENDER->NewImage('menu_goals.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_goals.png"/>
</a>

<a href="?module=converter" data-ajax="false" data-prefetch>
    <img alt="Converter" <?php echo $RENDER->NewImage('menu_converter.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_converter.png"/>
</a>

<a href="?module=profile" data-ajax="false" data-prefetch>
    <img alt="Profile" <?php echo $RENDER->NewImage('menu_profile.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_profile.png"/>
</a>

    <img alt="Workouts" <?php echo $RENDER->NewImage('menu_workouts.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_workouts.png"/>

<a href="?module=wod" data-ajax="false" data-prefetch>
    <img alt="WOD" <?php echo $RENDER->NewImage('menu_wodlog.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_wodlog.png"/>
</a>

<a href="?module=benchmark" data-ajax="false" data-prefetch>
    <img alt="Benchmarks" <?php echo $RENDER->NewImage('menu_benchmarks.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_benchmarks.png"/>
</a>

<a href="?module=baseline" data-ajax="false" data-prefetch>
    <img alt="Baseline" <?php echo $RENDER->NewImage('menu_baseline.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_baseline.png"/>
</a>

<a href="?module=challenge" data-ajax="false" data-prefetch>
    <img alt="Challenge" <?php echo $RENDER->NewImage('menu_challenges.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_challenges.png"/>
</a>

<a href="?module=foodlog" data-ajax="false" data-prefetch>
    <img alt="Nutrition" <?php echo $RENDER->NewImage('menu_nutrition.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_nutrition.png"/>
</a>

<a href="?module=book" data-ajax="false" data-prefetch>
    <img alt="Booking" <?php echo $RENDER->NewImage('menu_booking.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_booking.png"/>
</a>

<a href="?module=reports" data-ajax="false" data-prefetch>
    <img alt="Reports" <?php echo $RENDER->NewImage('menu_reports.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_reports.png"/>
</a>

<a href="?module=skills" data-ajax="false" data-prefetch>
    <img alt="Skills" <?php echo $RENDER->NewImage('menu_skills.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>menu_skills.png"/>
</a>

</div>
</div>	