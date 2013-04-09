<div id="slidemenu">
    <?php if(isset($_COOKIE['UID'])){?>
<ul><li<?php if($Module == 'profile'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/profile.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/profile.png"/><a href="" onclick="OpenThisPage('?module=profile');" class="contentLink"><?php echo $Display->UsersName();?></a></li></ul>
<?php } ?>
<div class="menusection">WOD</div>
	<ul>
		<li<?php if($Module == 'mygym'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/myGym.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/myGym.png"/><a href="" onclick="OpenThisPage('?module=mygym');" class="contentLink">My Gym WOD</a></li>
		<li<?php if($Module == 'custom'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/create.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/create.png"/><a href="" onclick="OpenThisPage('?module=custom');" class="contentLink">Create Personal WOD</a></li>
		<li<?php if($Module == 'personal'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/myPersonal.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/myPersonal.png"/><a href="" onclick="OpenThisPage('?module=personal');" class="contentLink">My Personal WODs</a></li>
		<li<?php if($Module == 'benchmark'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/bench.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/bench.png"/><a href="" onclick="OpenThisPage('?module=benchmarks');" class="contentLink">Benchmarks</a></li>
                <li<?php if($Module == 'completed'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/completed.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/completed.png"/><a href="" onclick="OpenThisPage('?module=completed');" class="contentLink">Completed WODs</a></li>
	</ul>

<div class="menusection">FEATURES</div>
	<ul>
		<li<?php if($Module == 'nutrition'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/nutrition.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/nutrition.png"/><a href="" onclick="OpenThisPage('?module=nutrition');" class="contentLink">Nutrition</a></li>
		<li<?php if($Module == 'reports'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/progress.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/progress.png"/><a href="" onclick="OpenThisPage('?module=reports');" class="contentLink">Progress</a></li>
		<li<?php if($Module == 'challenge'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/challenge.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/challenge.png"/><a href="" onclick="OpenThisPage('?module=challenge');" class="contentLink">Challenges</a></li>
		<li<?php if($Module == 'baseline'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/baseline.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/baseline.png"/><a href="" onclick="OpenThisPage('?module=baseline');" class="contentLink">My Baselines</a></li>
                <li<?php if($Module == 'skills'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/skills.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/skills.png"/><a href="" onclick="OpenThisPage('?module=skills');" class="contentLink">Skills Level</a></li>
	</ul>

<div class="menusection">MY GYM</div>
	<ul>
		<li<?php if($Module == 'registergym'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/register.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/register.png"/><a href="" onclick="OpenThisPage('?module=registergym');" class="contentLink">
                        <?php if(!$Display->UserGym()){ ?>
                            Register my gym
                        <?php }else{ ?>
                            Change my Gym
                        <?php } ?>
                    </a></li>
		<li<?php if($Module == 'book'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/schedule.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/schedule.png"/><a href="" onclick="OpenThisPage('?module=book');" class="contentLink">Schedule</a></li>
		<li<?php if($Module == 'locator'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/affiliate.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/affiliate.png"/><a href="" onclick="OpenThisPage('?module=locator');" class="contentLink">Affiliates</a></li>
                <li<?php if($Module == 'aboutcrossfit'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/aboutUs.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/aboutUs.png"/><a href="" onclick="OpenThisPage('?module=aboutcrossfit');" class="contentLink">About Us</a></li>
	</ul>

<div class="menusection">TOOLS</div>
	<ul>
		<li<?php if($Module == 'videos'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/search.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/search.png"/><a href="" onclick="OpenThisPage('?module=videos');" class="contentLink">Search</a></li>
                <li<?php if($Module == 'converter'){?> class="active"<?php } ?>><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/converter.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/converter.png"/><a href="" onclick="OpenThisPage('?module=converter');" class="contentLink">Converter</a></li>
	</ul>

<div class="menusection"></div>
	<ul>
		<li><img id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu/logout.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/logout.png"/><a href="" onclick="OpenThisPage('?module=logout');" class="contentLink">Logout</a></li>
	</ul>
</div>