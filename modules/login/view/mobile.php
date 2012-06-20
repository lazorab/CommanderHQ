<?php
    $ratio = $request->get_screen_width_new() / 500;
    $height = floor(660*$ratio);
    $spacer = floor(40*$ratio);
    ?>
<div id="loginback" style="height:<?php echo $height;?>px;background-image:url(<?php echo $RENDER->Image('signup.png', $request->get_screen_width_new());?>);">
<?php echo $Display->Message;?>
<div style="height:<?php echo $spacer;?>px"></div>
<div id="container" style="padding:5%">

<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
Username<br/>
<input type="text" name="username"/><br/>
Password<br/>
<input type="password" name="password"/><br/><br/>
Remember me
<input type="checkbox" name="remember" value="yes"/>

<img onclick="document.login.submit();" alt="Login" src="<?php echo $RENDER->Image('login.png', $device->GetScreenWidth());?>"/>
</form>

<br/>Not a member yet?
<a href="?module=register">
<img alt="Signup" src="<?php echo $RENDER->Image('register.png', $device->GetScreenWidth());?>"/>
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
<div style="height:<?php echo $spacer;?>px"></div>
<div style="height:<?php echo $spacer;?>px"></div>
<div style="height:<?php echo $spacer;?>px"></div>

<a href="#">
<img alt="Twitter" src="<?php echo $RENDER->Image('twitter.png', $device->GetScreenWidth());?>"/>
</a>
<a href="#">
<img alt="Google" src="<?php echo $RENDER->Image('google.png', $device->GetScreenWidth());?>"/>
</a>
<a href="#">
<img alt="Facebook" src="<?php echo $RENDER->Image('facebook.png', $device->GetScreenWidth());?>"/>
</a>

</div>
