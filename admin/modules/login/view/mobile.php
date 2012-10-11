<?php
    $ratio = SCREENWIDTH / 500;
    $height = floor(660*$ratio);
    $spacer = floor(150*$ratio);
    ?>
<div id="loginback">
<?php echo $Display->Message;?><br/>

<div id="container" style="color:#fff;height:350px;padding-left:20%">
<br/><br/>
<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
<input style="margin:0 5% 2% 5%;width:50%;" type="text" name="username" placeholder="Username" data-mini="true"/>
<input style="margin:0 5% 10% 5%;width:50%;" type="password" name="password" placeholder="Password" data-mini="true"/>
<a href="?module=forgot">forgot password?</a>
<br/>

Remember me
<input type="checkbox" id="remember" name="remember" value="yes" data-role="none"/>

<img onclick="document.login.submit();" alt="Login" <?php echo $RENDER->NewImage('login.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>login.png"/>
</form>

<br/>
Not a member yet?
<a href="?module=profile" style="margin-left:0.1%">
<img alt="Signup" <?php echo $RENDER->NewImage('register.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>register.png"/>
</a>
<br/>

<br/>
<br/>
<div style="margin:0 20% 2% 20%">Login with</div>

<div style="padding:0 5% 0 5%">
<!--
<a href="https://dev.twitter.com/docs/auth/implementing-sign-twitter">
-->
<a href="?module=login&oauth_provider=twitter" rel="external">
<img alt="Twitter" <?php echo $RENDER->NewImage('twitter.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>twitter.png"/></a>
<!--
<a href="https://developers.google.com/accounts/docs/OpenID#settingup">
-->
<a href="?module=login&oauth_provider=google" rel="external">
<img alt="Google" <?php echo $RENDER->NewImage('google.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>google.png"/>
</a>
<!--
<a href="http://developers.facebook.com/docs/authentication/server-side/">
-->
<a href="?module=login&oauth_provider=facebook" rel="external">
<img alt="Facebook" <?php echo $RENDER->NewImage('facebook.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>facebook.png"/>
</a>
</div>
</div>
</div>