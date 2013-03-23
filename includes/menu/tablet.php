<?php
session_start();
if(isset($_COOKIE['UID'])){ ?>

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