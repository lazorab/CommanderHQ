<div id="slidemenu">
    <?php if(isset($_COOKIE['UID'])){?>
<ul><li><?php echo $Display->UsersName();?></li></ul>
<?php } ?>
<div class="menusection">WOD</div>
	<ul>
		<li<?php if($Module == 'mygym'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=mygym');" class="contentLink">My Gym WOD</a></li>
		<li<?php if($Module == 'custom'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=custom');" class="contentLink">Create Personal WOD</a></li>
		<li<?php if($Module == 'personal'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=personal');" class="contentLink">My Personal WODs</a></li>
		<li<?php if($Module == 'benchmark'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=benchmarks');" class="contentLink">Benchmarks</a></li>
                <li<?php if($Module == 'completed'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=completed');" class="contentLink">Completed WODs</a></li>
	</ul>

<div class="menusection">FEATURES</div>
	<ul>
		<li<?php if($Module == 'nutrition'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=nutrition');" class="contentLink">Nutrition</a></li>
		<li><a href="" class="contentLink">Progress</a></li>
		<li<?php if($Module == 'challenge'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=challenge');" class="contentLink">Challenges</a></li>
		<li<?php if($Module == 'baseline'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=baseline');" class="contentLink">My Baselines</a></li>
                <li<?php if($Module == 'skills'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=skills');" class="contentLink">Skills Level</a></li>
	</ul>

<div class="menusection">MY GYM</div>
	<ul>
		<li<?php if($Module == 'registergym'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=registergym');" class="contentLink">
                        <?php if(!$Display->UserGym()){ ?>
                            Register my gym
                        <?php }else{ ?>
                            Change my Gym
                        <?php } ?>
                    </a></li>
		<li><a href="" class="contentLink">Booking</a></li>
		<li<?php if($Module == 'locator'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=locator');" class="contentLink">Affiliates</a></li>
                <li<?php if($Module == 'aboutcrossfit'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=aboutcrossfit');" class="contentLink">Crossfit</a></li>
	</ul>

<div class="menusection">TOOLS</div>
	<ul>
		<li<?php if($Module == 'videos'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=videos');" class="contentLink">Search</a></li>
                <li<?php if($Module == 'converter'){?> class="active"<?php } ?>><a href="" onclick="OpenThisPage('?module=converter');" class="contentLink">Converter</a></li>
	</ul>

<div class="menusection"></div>
	<ul>
		<li><a href="" onclick="OpenThisPage('?module=logout');" class="contentLink">Logout</a></li>
	</ul>
</div>