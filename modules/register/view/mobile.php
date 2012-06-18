<script type="text/javascript">
$(document).ready(function () {
                  var curr = new Date().getFullYear();
                  var opt = {}

                  opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd/mm/yy', timeFormat: ''  };
                  
                  $('#DOB').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));
                  
                  });	

</script>

<div id="menu" style="width:30%;float:left">
<div class="menuitem" style="margin:5%">
	<img alt="Register" src="<?php echo $RENDER->Image('register_active.png', $request->get_screen_width_new());?>"/>
</div>
<div class="menuitem" style="margin:5%">	
	<a href="?module=registergym"><img alt="GymRegister" src="<?php echo $RENDER->Image('registergym.png', $request->get_screen_width_new());?>"/></a>
</div>
<div class="menuitem" style="margin:5%">
	<a href="?module=goals"><img alt="Goals" src="<?php echo $RENDER->Image('goals.png', $request->get_screen_width_new());?>"/></a>
</div>
</div>

<div id="content" style="width:70%;float:left;color:#fff">
<?php if($Display->Message != ''){?>
	<div style="background-color:RED;color:#fff;font-weight:bold;padding:1%;width:75%">* <?php echo $Display->Message;?></div>
<?php } ?>
<br/>
<form action="index.php" method="post">
<input type="hidden" name="module" value="register"/>
<input type="hidden" name="formsubmitted" value="yes"/>
<input type="hidden" name="system" value="<?php echo $Display->System;?>"/>
First Name<br/>
<input type="text" name="firstname" value="<?php echo $_REQUEST['firstname'];?>"/><br/>
Last Name<br/>
<input type="text" name="lastname" value="<?php echo $_REQUEST['lastname'];?>"/><br/>
Cell<br/>
<input type="text" name="cell" value="<?php echo $_REQUEST['cell'];?>"/><br/>
Email<br/>
<input type="text" name="email" value="<?php echo $_REQUEST['email'];?>"/><br/>
Username<br/>
<input type="text" name="username" value="<?php echo $_REQUEST['username'];?>"/><br/>
Password<br/>
<input type="password" name="password" value="<?php echo $_REQUEST['password'];?>"/><br/><br/>
Date of Birth<br/>
<input type="text" id="DOB" name="DOB" value="<?php echo $_REQUEST['DOB'];?>"/>
<br/><br/>
Male<input type="radio" name="gender" value="M" <?php if($_REQUEST['gender'] == 'M') echo 'checked="checked"';?>/>Female<input type="radio" name="gender" value="F" <?php if($_REQUEST['gender'] == 'F') echo 'checked="checked"';?>/><br/>
<br/><br/>
Weight (<?php echo $Display->SystemWeight;?>)<br/>
<input type="text" name="weight" value="<?php echo $_REQUEST['weight'];?>"/>
<br/>
Height (<?php echo $Display->SystemHeight;?>)<br/>
<input type="text" name="height" value="<?php echo $_REQUEST['height'];?>"/>
<br/><br/>
Preferred Sytem of Measurement<br/>
<input type="submit" name="system" value="<?php echo $Display->AlternateSystem;?>"/>
<br/><br/>
<input type="submit" name="save" value="Save"/>
</form>
<br/>
</div>
<div class="clear"></div>