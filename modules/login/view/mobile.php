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
<div style="height:<?php echo $spacer;?>px"></div>
<div style="padding:0 15% 2% 15%">Login with</div>
<a href="#">
<img alt="Twitter" <?php echo $RENDER->NewImage('twitter.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>twitter.png"/>
</a>
<a href="#">
<img alt="Google" <?php echo $RENDER->NewImage('google.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>google.png"/>
</a>
<a href="#">
<img alt="Facebook" <?php echo $RENDER->NewImage('facebook.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>facebook.png"/>
</a>

</div>
