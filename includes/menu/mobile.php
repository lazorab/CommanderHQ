<?php
$ratio = SCREENWIDTH / LAYOUT_WIDTH;
$NavIconSize = floor(72*$ratio);

?>

<div id="nav" style="height:<?php echo floor(100*$ratio);?>px;">
		
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu.png"/>
</div>
 
<?php if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<a class="menuitem" href="#" onclick="OpenThisPage('?module=memberhome');" data-transition="slidefade" data-prefetch><img alt="Home" <?php echo $RENDER->NewImage('home.png');?> src="<?php echo IMAGE_RENDER_PATH;?>home.png"/></a>
</div>	
<?php } ?>

<div id="menuvideo" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;"></div>	

<div id="back" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	
</div>

<div id="AjaxLoading" class="grid" style="float:right;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 4% 2% 0;"></div>
</div>
<div class="clear"></div>
<div id="menu" data-role="menu">

<img id="menuarrow" alt="Up" <?php echo $RENDER->NewImage('menu_up.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_up.png"/>

<div>
<form action="index.php" method="post" name="searchform">

<div style="padding:2%;float:left;width:70%;"><input type="search" results="5" placeholder="Video Search" name="keyword" id="keyword"/></div>
<div style="float:left;margin:8px 0 0 0"><input type="button" name="btnSubmit" value="Go" data-inline="true" onclick="OpenThisPage('?module=videos&keyword='+keyword.value+'');"/></div>
</form>
</div>

<a href="#" onclick="OpenThisPage('?module=products');" data-transition="slidefade" data-prefetch>
<img alt="Store" <?php echo $RENDER->NewImage('menu_store.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_store.png"/>
</a>

    <img alt="Personal" <?php echo $RENDER->NewImage('menu_personal.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_personal.png"/>

<a href="#" onclick="OpenThisPage('?module=registergym');" data-transition="slidefade" data-prefetch>
    <img alt="Register" <?php echo $RENDER->NewImage('menu_register_gym.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_register_gym.png"/></a>

<a href="#" onclick="OpenThisPage('?module=goals');" data-transition="slidefade" data-prefetch>
    <img alt="Goals" <?php echo $RENDER->NewImage('menu_goals.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_goals.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=converter');" data-transition="slidefade" data-prefetch>
    <img alt="Converter" <?php echo $RENDER->NewImage('menu_converter.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_converter.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=profile');" data-transition="slidefade" data-prefetch>
    <img alt="Profile" <?php echo $RENDER->NewImage('menu_profile.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_profile.png"/>
</a>

    <img alt="Workouts" <?php echo $RENDER->NewImage('menu_workouts.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_workouts.png"/>

<a href="#" onclick="OpenThisPage('?module=wod');" data-transition="slidefade" data-prefetch>
    <img alt="WOD" <?php echo $RENDER->NewImage('menu_wod.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_wod.png"/>
</a>

<a href="" onclick="OpenThisPage('?module=benchmark');" data-transition="slidefade" data-prefetch>
    <img alt="Benchmarks" <?php echo $RENDER->NewImage('menu_benchmarks.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_benchmarks.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=baseline');" data-transition="slidefade" data-prefetch>
    <img alt="Baseline" <?php echo $RENDER->NewImage('menu_baseline.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_baseline.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=challenge');" data-transition="slidefade" data-prefetch>
    <img alt="Challenge" <?php echo $RENDER->NewImage('menu_challenges.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_challenges.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=nutrition');" data-transition="slidefade" data-prefetch>
    <img alt="Nutrition" <?php echo $RENDER->NewImage('menu_nutrition.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_nutrition.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=book');" data-transition="slidefade" data-prefetch>
    <img alt="Booking" <?php echo $RENDER->NewImage('menu_booking.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_booking.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=reports');" data-transition="slidefade" data-prefetch>
    <img alt="Reports" <?php echo $RENDER->NewImage('menu_reports.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_reports.png"/>
</a>

<a href="#" onclick="OpenThisPage('?module=skills');" data-transition="slidefade" data-prefetch>
    <img alt="Skills" <?php echo $RENDER->NewImage('menu_skills.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_skills.png"/>
</a>
    
<a href="#" onclick="OpenThisPage('?module=locator');" data-transition="slidefade" data-prefetch>
    <img alt="Affiliates" <?php echo $RENDER->NewImage('menu_affiliates.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_affiliates.png"/>
</a>
    
<a href="#" onclick="OpenThisPage('?module=aboutcrossfit');" data-transition="slidefade" data-prefetch>
    <img alt="About" <?php echo $RENDER->NewImage('menu_crossfit.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_crossfit.png"/>
</a>

<img alt="Down" <?php echo $RENDER->NewImage('menu_down.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu_down.png"/>

</div>

<script type="text/javascript">
$('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');     
</script>

<div data-role="popup" id="popupFeedback" data-theme="a" class="ui-corner-all">
<form id="feedbackform">
<div style="padding:10px 20px;">
<h3>Successfully Saved</h3>
<h3>Send us some feedback</h3>
<textarea id="feedback" name="Comments" cols="10" rows="20"></textarea>
<a style="width:40%;margin:4%;float:left" href="#" data-role="button" data-inline="true" onClick="SubmitFeedback();" data-theme="c">Submit</a>
<a style="width:40%;margin:4%;float:right" href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
<br/><br/><br/>
</div>
</form>
</div>
