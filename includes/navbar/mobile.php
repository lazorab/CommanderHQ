<?php
$ratio = SCREENWIDTH / LAYOUT_WIDTH;
$NavIconSize = floor(72*$ratio);
?>

<script type="text/javascript">
$('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');     
</script>

<div id="nav" style="height:<?php echo floor(72*$ratio);?>px; margin-bottom:<?php echo floor(8*$ratio);?>px;">
		
<div class="grid" style="float:left;width:<?php echo floor($NavIconSize+(32*$ratio));?>px;height:<?php echo $NavIconSize;?>px;margin:0;">
	<img class="jqm-navmenu-link" id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu.png"/>
</div>
 
<?php if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:0;">
	<a class="menuitem" href="#" onclick="OpenThisPage('?module=memberhome');" data-transition="slidefade" data-prefetch><img alt="Home" <?php echo $RENDER->NewImage('home.png');?> src="<?php echo IMAGE_RENDER_PATH;?>home.png"/></a>
</div>	
<?php } ?>

<div id="menuvideo" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:0;"></div>	

<div id="back" class="grid" style="float:right;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:0%;"></div>

</div>
<div class="clear"></div>



<div data-role="popup" id="popupFeedback" data-theme="a" class="ui-corner-all">
<form id="feedbackform">
<div style="padding:2%">
<h3>Successfully Saved</h3>
<textarea id="feedback" name="Comments" cols="10" rows="50" placeholder="Comments?"></textarea>
<div class="ui-grid-a">
<div class="ui-block-a"><a href="#" data-mini="true" data-role="button" data-inline="true" onClick="SubmitFeedback();" data-theme="c">Send</a></div>
<div class="ui-block-b"><a href="#" data-mini="true" data-role="button" data-inline="true" data-rel="back" data-theme="c">Close</a></div>
</div>
</div>
</form>
</div>
