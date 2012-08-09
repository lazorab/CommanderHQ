<?php
$ratio = SCREENWIDTH / 640;
$NavIconSize = floor(72*$ratio);
?>

<div id="nav" style="height:<?php echo floor(100*$ratio);?>px;">

<?php if(isset($_REQUEST['wodtype']) || isset($_REQUEST['catid']) || isset($_REQUEST['baseline']) || isset($_REQUEST['report']) || isset($_REQUEST['customexercise'])){
	if(isset($_REQUEST['customexercise']))
		$BackModule = $_REQUEST['module']."&origin=".$_REQUEST['origin'];
	else
		$BackModule = $_REQUEST['module'];
?>
		
<div id="back" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<img alt="Back" onclick="OpenThisPage('?module=<?php echo $BackModule;?>');" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>
</div>
		
<?php } ?>

<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu.png"/>
</div>
 
<?php if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<a class="menuitem" href="#" onclick="OpenThisPage('?module=memberhome');" data-transition="slidefade" data-prefetch><img alt="Home" <?php echo $RENDER->NewImage('home.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>home.png"/></a>
</div>	
<?php } ?>

<div id="menuvideo" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 2% 4%;"></div>	

<div id="AjaxLoading" class="grid" style="float:right;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 4% 2% 0;"></div>
</div>
<div class="clear"></div>
<div id="menu" data-role="menu">

<img id="menuarrow" alt="Up" <?php echo $RENDER->NewImage('menu_up.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_up.png"/>

<div>
<form action="index.php" method="post" name="searchform">
<input type="hidden" name="module" value="videos"/>
<input type="hidden" name="formsubmitted" value="yes"/>
<div style="padding:2%;float:left;width:70%;"><input type="search" results="5" placeholder="Search" name="keyword"/></div>
<div style="float:left;"><input type="button" name="btnSubmit" value="Go" data-inline="true" onclick="this.form.submit();"/></div>
</form>
</div>

<a href="#" onclick="OpenThisPage('?module=products');" data-transition="slidefade" data-prefetch>
<img alt="Store" <?php echo $RENDER->NewImage('menu_store.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_store.png"/>
</a>

    <img alt="Personal" <?php echo $RENDER->NewImage('menu_personal.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_personal.png"/>

<a href="#" onclick="OpenThisPage('?module=registergym');" data-transition="slidefade" data-prefetch>
    <img alt="Register" <?php echo $RENDER->NewImage('menu_register_gym.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_register_gym.png"/></a>

<a href="#" onclick="OpenThisPage('?module=goals');" data-transition="slidefade" data-prefetch>
    <img alt="Goals" <?php echo $RENDER->NewImage('menu_goals.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_goals.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=converter');" data-transition="slidefade" data-prefetch>
    <img alt="Converter" <?php echo $RENDER->NewImage('menu_converter.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_converter.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=profile');" data-transition="slidefade" data-prefetch>
    <img alt="Profile" <?php echo $RENDER->NewImage('menu_profile.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_profile.png"/>
</a>

    <img alt="Workouts" <?php echo $RENDER->NewImage('menu_workouts.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_workouts.png"/>

<a href="#" onclick="OpenThisPage('?module=wod');" data-transition="slidefade" data-prefetch>
    <img alt="WOD" <?php echo $RENDER->NewImage('menu_wodlog.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_wodlog.png"/>
</a>

<a href="" onclick="OpenThisPage('?module=benchmark');" data-transition="slidefade" data-prefetch>
    <img alt="Benchmarks" <?php echo $RENDER->NewImage('menu_benchmarks.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_benchmarks.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=baseline');" data-transition="slidefade" data-prefetch>
    <img alt="Baseline" <?php echo $RENDER->NewImage('menu_baseline.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_baseline.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=challenge');" data-transition="slidefade" data-prefetch>
    <img alt="Challenge" <?php echo $RENDER->NewImage('menu_challenges.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_challenges.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=foodlog');" data-transition="slidefade" data-prefetch>
    <img alt="Nutrition" <?php echo $RENDER->NewImage('menu_nutrition.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_nutrition.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=book');" data-transition="slidefade" data-prefetch>
    <img alt="Booking" <?php echo $RENDER->NewImage('menu_booking.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_booking.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=reports');" data-transition="slidefade" data-prefetch>
    <img alt="Reports" <?php echo $RENDER->NewImage('menu_reports.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_reports.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=skills');" data-transition="slidefade" data-prefetch>
    <img alt="Skills" <?php echo $RENDER->NewImage('menu_skills.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_skills.png"/>
</a>

<img alt="Down" <?php echo $RENDER->NewImage('menu_down.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>menu_down.png"/>

</div>
