<script type="text/javascript">
function savedetails()
{
	if(document.form.gymname.value == '')
		alert('Gym Name Required');
	else if(document.form.url.value == '')
		alert('URL Required');	
	else{
		document.form.submit();
	}
}
</script>

<div id="content" style="width:70%;float:left;color:#fff">
<?php if($Display->Message != ''){?>
	<div id="message">* <?php echo $Display->Message;?></div>
<?php } ?>
<br/>
<form action="index.php" method="post" name="form">
<div data-role="fieldcontain">
<input type="hidden" name="module" value="registergym"/>
<input type="hidden" name="save" value="Save"/>
<label for="gymname">Gym Name</label>
<input style="width:75%;" type="text" id="gymname" name="gymname" value="<?php echo $_REQUEST['gymname'];?>"/><br/>
<label for="country">Country</label>
<input style="width:75%;" type="text" id="country" name="country" value="<?php echo $_REQUEST['country'];?>"/><br/>
<label for="region">Region</label>
<input style="width:75%;" type="text" id="region" name="region" value="<?php echo $_REQUEST['region'];?>"/><br/>
<label for="tel">Tel</label>
<input style="width:75%;" type="tel" id="tel" name="tel" value="<?php echo $_REQUEST['tel'];?>" placeholder="+2778000000"/>
<label for="email">Email</label>
<input style="width:75%;" type="email" id="email" name="email" value="<?php echo $_REQUEST['email'];?>"/><br/>
<label for="url">URL</label>
<input style="width:75%;" type="text" id="url" name="url" value="<?php echo $_REQUEST['url'];?>"/><br/>
<br/><br/>
<input type="button" onclick="savedetails();" value="Save"/>
</div>
</form>
<br/>
</div>
<div class="clear"></div>