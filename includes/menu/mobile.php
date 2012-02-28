<div id="header">
	<wall:img alt="Header" src="<?php echo $RENDER->Image('img.jpg', $request->get_screen_width_new());?>"/>
</div>
<?php
session_start();
if(isset($_SESSION['UID'])){ ?>

<wall:a href="?page=memberhome">Home</wall:a>
<wall:a href="?page=reports">Reports</wall:a>
<wall:a href="?page=exerciseplan">ExercisePlan</wall:a>
<wall:a href="?page=benchmark">BenchmarkWorkouts</wall:a>
<wall:a href="?page=wod">WOD</wall:a>
<wall:a href="?page=challenge">Challenge</wall:a>
<wall:a href="?page=travelworkouts">TravelWorkouts</wall:a>
<wall:a href="?page=exerciselog">QuickLog</wall:a>
<wall:a href="?page=foodlog">FoodLog</wall:a>
<wall:a href="?page=recipes">Recipes</wall:a>
<wall:a href="?page=videos">Videos</wall:a>
<wall:a href="?page=logout">LogOut</wall:a>

<?php } else { ?>

<wall:a href="?page=about">About</wall:a>
<wall:a href="?page=map">Map</wall:a>
<wall:a href="?page=register">Register</wall:a>
<wall:a href="?page=login">Login</wall:a>

<?php } ?>