<?php echo $Display->Message;?>
<br/><br/>
<form action="index.php" method="post">
<input type="hidden" name="module" value="register"/>
<input type="hidden" name="formsubmitted" value="yes"/>
<input type="hidden" name="system" value="<?php echo $Display->System;?>"/>
First Name<br/>
<input type="text" name="firstname" value="<?php echo $_REQUEST['firstname'];?>"/>
<br/>
Last Name<br/>
<input type="text" name="lastname" value="<?php echo $_REQUEST['lastname'];?>"/>
<br/>
Cell<br/>
<input type="text" name="cell" value="<?php echo $_REQUEST['cell'];?>"/>
<br/>
Email<br/>
<input type="text" name="email" value="<?php echo $_REQUEST['email'];?>"/>
<br/>
Username<br/>
<input type="text" name="username" value="<?php echo $_REQUEST['username'];?>"/>
<br/>
Password<br/>
<input type="password" name="password" value="<?php echo $_REQUEST['password'];?>"/>
<br/>
Date of Birth<br/>
<select name="day">
<?php echo $Display->Model()->DayOptions($_REQUEST['day']);?>
</select>
<select name="month">
<?php echo $Display->Model()->MonthOptions($_REQUEST['month']);?>
</select>
<select name="year">
<?php echo $Display->Model()->YearOptions($_REQUEST['year']);?>
</select>
<br/><br/>
Male<input type="radio" name="gender" value="M" <?php if($_REQUEST['gender'] == 'M') echo 'checked="checked"';?>/>Female<input type="radio" name="gender" value="F" <?php if($_REQUEST['gender'] == 'F') echo 'checked="checked"';?>/>
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
<input type="submit" name="submit" value="Save"/>
</form>