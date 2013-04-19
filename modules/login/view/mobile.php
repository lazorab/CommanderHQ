
<div id="loginback">
<?php 

if (isset($Display->Message) && strlen($Display->Message) > 0) {?>
	<script language="javascript">
       alert("<?php echo $Display->Message; ?>");
	</script> 
<?php } ?><br/>

<div id="container" style="color:#fff;height:350px;padding:0 20% 0 20%">
<br/><br/>
<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
<input type="text" name="username" placeholder="Username" data-mini="true"/>
<input type="password" name="password" placeholder="Password" data-mini="true"/>
<a href="?module=forgot">forgot password?</a>
<br/>

Remember me
<input type="checkbox" id="remember" name="remember" value="yes" data-role="none"
<?php if(isset($_COOKIE['Username']) && isset($_COOKIE['Password'])){?>
       checked="checked"
<?php } ?>
/>
<button onclick="document.login.submit();" data-mini="true">Log In</button>
</form>

<br/>
Not a member yet?
<a href="?module=signup">
<button data-mini="true">Sign Up</button>
</a>
<br/>

<div style="margin:0 20% 0 20%">Login with</div>

<div style="padding:0 5% 0 5%">
<!--
<a href="https://dev.twitter.com/docs/auth/implementing-sign-twitter">
-->
<a href="?module=login&oauth_provider=twitter" rel="external">
<img alt="Twitter" <?php echo $RENDER->NewImage('twitter.png');?> src="<?php echo IMAGE_RENDER_PATH;?>twitter.png"/></a>
<!--
<a href="https://developers.google.com/accounts/docs/OpenID#settingup">
-->
<a href="?module=login&oauth_provider=google" rel="external">
<img alt="Google" <?php echo $RENDER->NewImage('google.png');?> src="<?php echo IMAGE_RENDER_PATH;?>google.png"/>
</a>
<!--
<a href="http://developers.facebook.com/docs/authentication/server-side/">
-->
<a href="?module=login&oauth_provider=facebook" rel="external">
<img alt="Facebook" <?php echo $RENDER->NewImage('facebook.png');?> src="<?php echo IMAGE_RENDER_PATH;?>facebook.png"/>
</a>
</div>
</div>
</div>