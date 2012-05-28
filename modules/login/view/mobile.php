<div id="menu" style="width:30%;float:left">
<div id="menuitem" style="margin:5%">
	<img alt="Register" src="<?php echo $RENDER->Image('register.png', $request->get_screen_width_new());?>"/>
</div>
</div>
<div id="content" style="width:70%;float:left;color:#fff">
<?php echo $Display->Message;?>
<wall:br/>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="module" value="login"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
Username<wall:br/>
<wall:input type="text" name="username"/><wall:br/>
Password<wall:br/>
<wall:input type="password" name="password"/><wall:br/><wall:br/>
Remember me
<wall:input type="checkbox" name="remember" value="yes"/><wall:br/><wall:br/>
<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
Forgot Password?<wall:br/>
Enter your Email<wall:br/>
<wall:input type="text" name="email"/><wall:br/><wall:br/>
<wall:input type="submit" name="submit" value="Retrieve"/><wall:br/><wall:br/>
</wall:form>
</div>
<div class="clear"></div>