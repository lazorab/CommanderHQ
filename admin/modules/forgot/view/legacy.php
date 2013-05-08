<?php
    $ratio = $request->get_screen_width_new() / 640;
    $height = floor(660*$ratio);
    $spacer = floor(190*$ratio);
    ?>
<div id="loginback" style="height:<?php echo $height;?>px;background-image:url(<?php echo $RENDER->Image('signup.png', $request->get_screen_width_new());?>);">

<?php echo $Display->Message;?><br/>

<div id="container" style="padding-left:5%">

<wall:form action="index.php" name="login" method="post">
<wall:input type="hidden" name="module" value="login"/>
<wall:input type="hidden" name="action" value="Login"/>
Username<br/>
<wall:input style="margin-bottom:2%" type="text" name="username"/><wall:br/>
Password<br/>
<wall:input type="password" name="password"/><wall:br/><wall:br/>
Remember me
<wall:input type="checkbox" name="remember" value="yes"/>

<wall:img onclick="document.login.submit();" alt="Login" <?php echo $RENDER->NewImage('login.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>login.png"/>
</wall:form>
<wall:br/>
Not a member yet?
<wall:a href="?module=register" style="margin-left:0.1%">
<wall:img alt="Signup" <?php echo $RENDER->NewImage('register.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>register.png"/>
</wall:a>
<wall:br/>
<!--
<wall:form action="index.php" name="retrieve" method="post">
<wall:input type="hidden" name="module" value="login"/>
Forgot Password?<wall:br/>
Enter your Email<wall:br/>
<wall:input type="text" name="email"/><wall:br/><wall:br/>
<wall:input type="submit" name="action" value="Retrieve"/><wall:br/><wall:br/>
</wall:form>
-->
<div style="height:<?php echo $spacer;?>px"></div>
<div style="padding:0 15% 2% 15%">Login with</div>
<wall:a href="#">
<wall:img alt="Twitter" <?php echo $RENDER->NewImage('twitter.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>twitter.png"/>
</wall:a>
<wall:a href="#">
<wall:img alt="Google" <?php echo $RENDER->NewImage('google.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>google.png"/>
</wall:a>
<wall:a href="#">
<wall:img alt="Facebook" <?php echo $RENDER->NewImage('facebook.png', $request->get_screen_width_new());?> src="<?php echo ImagePath;?>facebook.png"/>
</wall:a>

</div>