<div id="menu" style="width:30%;float:left">
<div id="menuitem" style="margin:5%">
	<img alt="Register" src="<?php echo $RENDER->Image('register.png', $request->get_screen_width_new());?>"/>
</div>
</div>
<div id="content" style="width:70%;float:left;color:#fff">
<?php echo $Display->Message;?>
<br/>
<form action="index.php" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="formsubmitted" value="yes"/>
Username<br/>
<input type="text" name="username"/><br/>
Password<br/>
<input type="password" name="password"/><br/><br/>
Remember me
<input type="checkbox" name="remember" value="yes"/><br/><br/>
<input type="submit" name="submit" value="Submit"/><br/><br/>
Forgot Password?<br/>
Enter your Email<br/>
<input type="text" name="email"/><br/><br/>
<input type="submit" name="submit" value="Retrieve"/><br/><br/>
</form>
</div>
<div class="clear"></div>