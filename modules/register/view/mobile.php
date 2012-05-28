<div id="menu" style="width:30%;float:left">
<div id="menuitem" style="margin:5%">
	<img alt="Register" src="<?php echo $RENDER->Image('register_active.png', $request->get_screen_width_new());?>"/>
</div>
<div id="menuitem" style="margin:5%">	
	<a href="?module=registergym"><img alt="GymRegister" src="<?php echo $RENDER->Image('registergym.png', $request->get_screen_width_new());?>"/></a>
</div>
<div id="menuitem" style="margin:5%">
	<a href="?module=goals"><img alt="Goals" src="<?php echo $RENDER->Image('goals.png', $request->get_screen_width_new());?>"/></a>
</div>
</div>

<div id="content" style="width:70%;float:left;color:#fff">
<?php if($Display->Message != ''){?>
	<div style="background-color:RED;color:#fff;font-weight:bold;padding:1%;width:75%">* <?php echo $Display->Message;?></div>
<?php } ?>
<wall:br/>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="module" value="register"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
<wall:input type="hidden" name="system" value="<?php echo $Display->System;?>"/>
First Name<wall:br/>
<wall:input type="text" name="firstname" value="<?php echo $_REQUEST['firstname'];?>"/><wall:br/>
Last Name<wall:br/>
<wall:input type="text" name="lastname" value="<?php echo $_REQUEST['lastname'];?>"/><wall:br/>
Cell<wall:br/>
<wall:input type="text" name="cell" value="<?php echo $_REQUEST['cell'];?>"/><wall:br/>
Email<wall:br/>
<wall:input type="text" name="email" value="<?php echo $_REQUEST['email'];?>"/><wall:br/>
Username<wall:br/>
<wall:input type="text" name="username" value="<?php echo $_REQUEST['username'];?>"/><wall:br/>
Password<wall:br/>
<wall:input type="password" name="password" value="<?php echo $_REQUEST['password'];?>"/><wall:br/><wall:br/>
Date of Birth<wall:br/>
<wall:select name="day">
<?php echo $Display->Model()->DayOptions($_REQUEST['day']);?>
</wall:select>
<wall:select name="month">
<?php echo $Display->Model()->MonthOptions($_REQUEST['month']);?>
</wall:select>
<wall:select name="year">
<?php echo $Display->Model()->YearOptions($_REQUEST['year']);?>
</wall:select>
<wall:br/><wall:br/>
Male<wall:input type="radio" name="gender" value="M" <?php if($_REQUEST['gender'] == 'M') echo 'checked="checked"';?>/>Female<wall:input type="radio" name="gender" value="F" <?php if($_REQUEST['gender'] == 'F') echo 'checked="checked"';?>/><wall:br/>
<wall:br/><wall:br/>
Weight (<?php echo $Display->SystemWeight;?>)<wall:br/>
<wall:input type="text" name="weight" value="<?php echo $_REQUEST['weight'];?>"/>
<wall:br/>
Height (<?php echo $Display->SystemHeight;?>)<wall:br/>
<wall:input type="text" name="height" value="<?php echo $_REQUEST['height'];?>"/>
<wall:br/><wall:br/>
Preferred Sytem of Measurement<wall:br/>
<wall:input type="submit" name="system" value="<?php echo $Display->AlternateSystem;?>"/>
<wall:br/><wall:br/>
<wall:input type="submit" name="submit" value="Save"/>
</wall:form>
<wall:br/>
</div>
<div class="clear"></div>