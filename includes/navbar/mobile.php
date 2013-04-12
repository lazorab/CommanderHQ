<?php
$ratio = SCREENWIDTH / LAYOUT_WIDTH;
$NavIconSize = floor(72*$ratio);
?>

<script type="text/javascript">
$('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');     
</script>

<div id="nav" style="height:<?php echo floor(100*$ratio);?>px;">
		
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:0;">
	<img class="ShowSlideMenu" id="menuselect" alt="Menu" <?php echo $RENDER->NewImage('menu.png');?> src="<?php echo IMAGE_RENDER_PATH;?>menu.png"/>
</div>
 
<?php if(isset($_REQUEST['module']) && ($_REQUEST['module'] != 'memberhome' && $_REQUEST['module'] != 'index')){ ?>
<div class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	<a class="menuitem" href="#" onclick="OpenThisPage('?module=memberhome');" data-transition="slidefade" data-prefetch><img alt="Home" <?php echo $RENDER->NewImage('home.png');?> src="<?php echo IMAGE_RENDER_PATH;?>home.png"/></a>
</div>	
<?php } ?>

<div id="menuvideo" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;"></div>	

<div id="back" class="grid" style="float:left;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 0 0 4%;">
	
</div>

<div id="AjaxLoading" class="grid" style="float:right;width:<?php echo $NavIconSize;?>px;height:<?php echo $NavIconSize;?>px;margin:2% 4% 2% 0;"></div>
</div>
<div class="clear"></div>



<div data-role="popup" id="popupFeedback" data-theme="a" class="ui-corner-all">
<form id="feedbackform">
<div style="padding:10px 20px;">
<h3>Successfully Saved</h3>
<textarea id="feedback" name="Comments" cols="10" rows="50" placeholder="Send us your comments"></textarea>
<a style="width:40%;margin:4%;float:left" href="#" data-role="button" data-inline="true" onClick="SubmitFeedback();" data-theme="c">Submit</a>
<a style="width:40%;margin:4%;float:right" href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
<br/><br/><br/>
</div>
</form>
</div>
