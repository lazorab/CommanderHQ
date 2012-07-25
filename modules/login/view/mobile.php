<?php
    $ratio = $request->get_screen_width_new() / 500;
    $height = floor(660*$ratio);
    $spacer = floor(150*$ratio);
    ?>
<div id="loginback">
<?php echo $Display->Message;?><br/>

<div id="container" style="padding-left:5%">

<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
<input style="width:50%;" type="text" name="username" placeholder="Username" data-mini="true"/>
<input style="width:50%;" type="password" name="password" placeholder="Password" data-mini="true"/>
<br/>
Remember me
<input type="checkbox" id="remember" name="remember" value="yes" data-role="none"/>

<img onclick="document.login.submit();" alt="Login" <?php echo $RENDER->NewImage('login.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>login.png"/>
</form>

<br/>
Not a member yet?
<a href="?module=profile" style="margin-left:0.1%">
<img alt="Signup" <?php echo $RENDER->NewImage('register.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>register.png"/>
</a>
<br/>
<!--
<form action="index.php" name="retrieve" method="post">
<input type="hidden" name="module" value="login"/>
Forgot Password?<br/>
Enter your Email<br/>
<input type="text" name="email"/><br/><br/>
<input type="submit" name="action" value="Retrieve"/><br/><br/>
</form>
-->
<br/>
<br/>
<div style="padding:0 15% 2% 15%">Login with</div>
<!--
<a href="https://dev.twitter.com/docs/auth/implementing-sign-twitter">
-->
<a href="?module=login&oauth_provider=twitter" rel="external">
<img alt="Twitter" <?php echo $RENDER->NewImage('twitter.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>twitter.png"/></a>
<!--
<a href="https://developers.google.com/accounts/docs/OpenID#settingup">
-->
<a href="?module=login&oauth_provider=google" rel="external">
<img alt="Google" <?php echo $RENDER->NewImage('google.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>google.png"/>
</a>
<!--
<a href="http://developers.facebook.com/docs/authentication/server-side/">
-->
<a href="?module=login&oauth_provider=facebook" rel="external">
<img alt="Facebook" <?php echo $RENDER->NewImage('facebook.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>facebook.png"/>
</a>
</div></div>