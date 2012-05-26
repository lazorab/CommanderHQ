<?php
$ratio = $request->get_screen_width_new() / 500;
$NavIconSize = floor(58*$ratio);
?>
<div id="nav" style="height:<?php echo floor(106*$ratio);?>px;background-image:url(<?php echo $RENDER->Image('navbar_slice.png', $request->get_screen_width_new());?>);repeat-x">
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 10%;">
<img alt="Header" src="<?php echo $RENDER->Image('reports2.png', $request->get_screen_width_new());?>"/>
</div>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
<img alt="Header" src="<?php echo $RENDER->Image('shop.png', $request->get_screen_width_new());?>"/>
</div>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
<img alt="Header" src="<?php echo $RENDER->Image('profile.png', $request->get_screen_width_new());?>"/>
</div>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
<img alt="Header" src="<?php echo $RENDER->Image('search.png', $request->get_screen_width_new());?>"/>
</div>
<?php
if(isset($_SESSION['UID'])){ ?>

<a href="?module=memberhome">Home</a>
<a href="?module=reports">Reports</a>
<a href="?module=exerciseplan">ExercisePlan</a>
<a href="?module=benchmark">BenchmarkWorkouts</a>
<a href="?module=wod">WOD</a>
<a href="?module=challenge">Challenge</a>
<a href="?module=travelworkouts">TravelWorkouts</a>
<a href="?module=exerciselog">QuickLog</a>
<a href="?module=foodlog">FoodLog</a>
<a href="?module=recipes">Recipes</a>
<a href="?module=products">Products</a>
<a href="?module=videos">Videos</a>
<a href="?module=logout">LogOut</a>

<?php } else { ?>

<a href="?module=about">About</a>
<a href="?module=map">Map</a>
<a href="?module=register">Register</a>
<a href="?module=login">Login</a>

<?php } ?>
</div>