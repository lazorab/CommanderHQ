<?php
$ratio = $request->get_screen_width_new() / 500;
$NavIconSize = floor(58*$ratio);
?>
<div id="nav" style="height:<?php echo floor(106*$ratio);?>px;background-image:url(<?php echo $RENDER->Image('navbar_slice.png', $request->get_screen_width_new());?>);repeat-x">
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 10%;">
<wall:img alt="Header" src="<?php echo $RENDER->Image('reports2.png', $request->get_screen_width_new());?>"/>
</div>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
<wall:img alt="Header" src="<?php echo $RENDER->Image('shop.png', $request->get_screen_width_new());?>"/>
</div>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
<wall:img alt="Header" src="<?php echo $RENDER->Image('profile.png', $request->get_screen_width_new());?>"/>
</div>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
<wall:img alt="Header" src="<?php echo $RENDER->Image('search.png', $request->get_screen_width_new());?>"/>
</div>
<?php
if(isset($_SESSION['UID'])){ ?>

<wall:a href="?module=memberhome">Home</wall:a>
<wall:a href="?module=reports">Reports</wall:a>
<wall:a href="?module=exerciseplan">ExercisePlan</wall:a>
<wall:a href="?module=benchmark">BenchmarkWorkouts</wall:a>
<wall:a href="?module=wod">WOD</wall:a>
<wall:a href="?module=challenge">Challenge</wall:a>
<wall:a href="?module=travelworkouts">TravelWorkouts</wall:a>
<wall:a href="?module=exerciselog">QuickLog</wall:a>
<wall:a href="?module=foodlog">FoodLog</wall:a>
<wall:a href="?module=recipes">Recipes</wall:a>
<wall:a href="?module=products">Products</wall:a>
<wall:a href="?module=videos">Videos</wall:a>
<wall:a href="?module=logout">LogOut</wall:a>

<?php } else { ?>

<wall:a href="?module=about">About</wall:a>
<wall:a href="?module=map">Map</wall:a>
<wall:a href="?module=register">Register</wall:a>
<wall:a href="?module=login">Login</wall:a>

<?php } ?>
</div>