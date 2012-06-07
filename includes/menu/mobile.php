<?php
$ratio = $request->get_screen_width_new() / 500;
$NavIconSize = floor(58*$ratio);
?>
<div id="nav" style="height:<?php echo floor(106*$ratio);?>px;background-image:url(<?php echo $RENDER->Image('navbar_slice.png', $request->get_screen_width_new());?>);repeat-x">

<?php 
if(isset($_SESSION['UID'])){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 10%;">
	<img onclick="getMenu();" id="menuselect" alt="Menu" src="<?php echo $RENDER->Image('menu.png', $request->get_screen_width_new());?>"/>
</div>
<?php if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
	<a class="menuitem" href="?module=memberhome" data-prefetch><img alt="Home" src="<?php echo $RENDER->Image('home.png', $request->get_screen_width_new());?>"/></a>
</div>	
<?php }	
 }else{ ?>
<?php if(isset($_REQUEST['module']) && ($_REQUEST['module'] != '' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
	<a class="menuitem" href="index.php" data-prefetch><img alt="Home" src="<?php echo $RENDER->Image('home.png', $request->get_screen_width_new());?>"/></a>
</div>	
<?php } ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
	<img onclick="getMenu();" id="menuselect" alt="Menu" src="<?php echo $RENDER->Image('menu.png', $request->get_screen_width_new());?>"/>
</div>	
<?php } 
if(isset($_REQUEST['video']) && $_REQUEST['video'] != ''){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:4% 0 4% 4%;">
	<img id="videobutton" onclick="GetVideo('http://www.youtube.com/embed/<?php echo $_REQUEST['video'];?>')" alt="Video" src="<?php echo $RENDER->Image('video_specific.png', $request->get_screen_width_new());?>"/>
</div>
<?php } 



/*
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

<?php } */?>
</div>
<div class="clear"></div>