
<div id="container">
<?php echo $Display->Message;?><br/>
<br/><br/>
<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
<input style="margin:0 3px 2px 3px;width:300px;" type="text" name="username" placeholder="Username" data-mini="true"/>
<input style="margin:0 3px 6px 3px;width:300px;" type="password" name="password" placeholder="Password" data-mini="true"/>
<a href="?module=forgot">forgot password?</a>
<br/>

Remember me
<input type="checkbox" id="remember" name="remember" value="yes" data-role="none"/>

<img onclick="document.login.submit();" alt="Login" src="<?php echo IMAGE_RENDER_PATH;?>login.png"/>
</form>

<br/>
Not a member yet?
<a href="?module=profile" style="margin-left:0.1%">
<img alt="Signup" src="<?php echo IMAGE_RENDER_PATH;?>register.png"/>
</a>
<br/>

<br/>
<br/>


</div>