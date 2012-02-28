<div id="header">
	<wall:img alt="Header" src="<?php echo $RENDER->Image('img.jpg', $request->get_screen_width_new());?>"/>
</div>
<?php
session_start();
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
<wall:a href="?module=videos">Videos</wall:a>
<wall:a href="?module=logout">LogOut</wall:a>

<?php } else { ?>

<wall:a href="?module=about">About</wall:a>
<wall:a href="?module=map">Map</wall:a>
<wall:a href="?module=register">Register</wall:a>
<wall:a href="?module=login">Login</wall:a>

<?php } ?>