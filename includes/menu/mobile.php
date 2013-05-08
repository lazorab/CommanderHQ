<div id="slidemenu" class="jqm-navmenu-panel" data-role="panel" data-position="left" data-display="push">
<?php if(isset($_COOKIE['UID'])){?>
<ul>
    <li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'profile'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/profile.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/profile.png"/><a href="" onclick="OpenThisPage('?module=profile');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>"><?php echo $Display->UsersName();?></a></li>
</ul>
<?php } ?>
<div class="menusection">WOD</div>
	<ul>
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'mygym'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/myGym.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/myGym.png"/><a href="" onclick="OpenThisPage('?module=mygym');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">My Gym WOD</a></li>
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'custom'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/create.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/create.png"/><a href="" onclick="OpenThisPage('?module=custom');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Create Personal WOD</a></li>
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'personal'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/myPersonal.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/myPersonal.png"/><a href="" onclick="OpenThisPage('?module=personal');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">My Personal WODs</a></li>
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'benchmark'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/bench.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/bench.png"/><a href="" onclick="OpenThisPage('?module=benchmark');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Benchmarks</a></li>
                <li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'completed'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/completed.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/completed.png"/><a href="" onclick="OpenThisPage('?module=completed');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Completed WODs</a></li>
	</ul>

<div class="menusection">FEATURES</div>
	<ul>
<!--		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'nutrition'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/nutrition.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/nutrition.png" style="<?php echo $Display->NewFontSize('32')?>"/>Nutrition</li> -->
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'reports'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/progress.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/progress.png"/><a href="" onclick="OpenThisPage('?module=reports');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Progress</a></li>
<!--		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'challenge'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/challenge.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/challenge.png" style="<?php echo $Display->NewFontSize('32')?>"/>Challenges</li>-->
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'baseline'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/baseline.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/baseline.png"/><a href="" onclick="OpenThisPage('?module=baseline');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">My Baselines</a></li>
                <li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'skills'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/skills.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/skills.png"/><a href="" onclick="OpenThisPage('?module=skills');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Skills Level</a></li>
	</ul>

<div class="menusection">MY GYM</div>
	<ul>
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'registergym'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/register.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/register.png"/><a href="" onclick="OpenThisPage('?module=registergym');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">
                        <?php if(!$Display->UserGym()){ ?>Register my gym
                        <?php }else{ ?>Change my Gym
                        <?php } ?>
                    </a></li>
<!--		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'book'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/schedule.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/schedule.png" style="<?php echo $Display->NewFontSize('32')?>"/>Schedule</li>-->
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'locator'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/affiliate.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/affiliate.png"/><a href="" onclick="OpenThisPage('?module=locator');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Affiliates</a></li>
                <li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'about'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/aboutUs.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/aboutUs.png"/><a href="" onclick="OpenThisPage('?module=about');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">About Us</a></li>
	</ul>

<div class="menusection">TOOLS</div>
	<ul>
		<li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'videos'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/search.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/search.png"/><a href="" onclick="OpenThisPage('?module=videos');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Search</a></li>
                <li style="<?php echo $Display->NewLineHeight('80')?>"<?php if($Module == 'converter'){?> class="active"<?php } ?>><img  alt="Menu" <?php echo $RENDER->NewImage('menu/converter.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/converter.png"/><a href="" onclick="OpenThisPage('?module=converter');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Converter</a></li>
	</ul>

<div class="menusection"></div>
	<ul>
            <li style="<?php echo $Display->NewLineHeight('80')?>"><img  alt="Menu" <?php echo $RENDER->NewImage('menu/help.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/help.png"/><a href="" onclick="OpenThisPage('?module=help');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Help</a></li>
            <li style="<?php echo $Display->NewLineHeight('80')?>"><img  alt="Menu" <?php echo $RENDER->NewImage('menu/logout.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/logout.png"/><a href="" onclick="OpenThisPage('?module=logout');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Logout</a></li>
            <li style="<?php echo $Display->NewLineHeight('80')?>"><img  alt="Menu" <?php echo $RENDER->NewImage('menu/tandc.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu/tandc.png"/><a href="" onclick="OpenThisPage('?module=terms');" class="contentLink" style="<?php echo $Display->NewFontSize('32')?>">Terms &amp; Conditions</a></li>
	</ul>
</div>