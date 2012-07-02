<?php
    $ratio = $request->get_screen_width_new() / 500;
    $height = floor(660*$ratio);
    $spacer = floor(190*$ratio);
    ?>
<div id="loginback" style="height:<?php echo $height;?>px;background-image:url(<?php echo $RENDER->Image('signup.png', $request->get_screen_width_new());?>);">

<?php echo $Display->Message;?><br/>

<div id="container" style="padding-left:5%">

<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
Username<br/>
<input style="margin-bottom:2%" type="text" name="username"/><br/>
Password<br/>
<input type="password" name="password"/><br/><br/>
Remember me
<input type="checkbox" name="remember" value="yes"/>

<img onclick="document.login.submit();" alt="Login" <?php echo $RENDER->NewImage('login.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>login.png"/>
</form>
<br/>
Not a member yet?
<a href="?module=register" style="margin-left:0.1%">
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
<form action="https://api.twitter.com/oauth/request_token" name="twitterform" method="post">
<input type="hidden" name="oauth_nonce" value="d8557ecf932b9cdf78b6ec5d556a6775"/>
<input type="hidden" name="oauth_callback" value="<?php echo urlencode('http://crossfit.be-mobile.co.za/index.php?module=memberhome');?>"/>
<input type="hidden" name="oauth_signature_method" value="HMAC-SHA1"/>
<input type="hidden" name="oauth_timestamp" value="<?php echo time();?>"/>
<input type="hidden" name="oauth_consumer_key" value="UndBfwSHLGKbvwHSIZIBag"/>
<input type="hidden" name="oauth_signature" value="GSmtp1fH7Bq8%2BvF9%2BstLsm1omws%3D"/>
<input type="hidden" name="oauth_version" value="1.0"/>
</form>
<div style="height:<?php echo $spacer;?>px"></div>
<div style="padding:0 15% 2% 15%">Login with</div>
<!--
<a href="https://dev.twitter.com/docs/auth/implementing-sign-twitter">
-->
<img onclick="document.twitterform.submit();" alt="Twitter" <?php echo $RENDER->NewImage('twitter.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>twitter.png"/>
<!--
<a href="https://developers.google.com/accounts/docs/OpenID#settingup">
-->
<img alt="Google" <?php echo $RENDER->NewImage('google.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>google.png"/>
<!--
<a href="http://developers.facebook.com/docs/authentication/server-side/">
-->
<img alt="Facebook" <?php echo $RENDER->NewImage('facebook.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>facebook.png"/>

</div>
