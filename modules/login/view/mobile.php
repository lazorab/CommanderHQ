<?php
    $ratio = $request->get_screen_width_new() / 500;
    $height=floor(660*$ratio);
    $spacer=floor(200*$ratio);
    ?>
<div id="loginback" style="height:<?php echo $height;?>px;background-image:url(<?php echo $RENDER->Image('signup.png', $request->get_screen_width_new());?>);">
<?php echo $Display->Message;?>
<br/>

<div style="height:<?php echo $spacer;?>px"></div>

<div id="container">
<center>
<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
Username<br/>
<input type="text" name="username"/><br/>
Password<br/>
<input type="password" name="password"/><br/><br/>
Remember me
<input type="checkbox" name="remember" value="yes"/><br/><br/>

<img onclick="document.login.submit();" alt="Header" src="<?php echo $RENDER->Image('login.png', $device->GetScreenWidth());?>"/>
<a href="?module=register">
<img onclick="document.login.submit();" alt="Header" src="<?php echo $RENDER->Image('register.png', $device->GetScreenWidth());?>"/>
</a>
</form>
<form action="index.php" name="retrieve" method="post">
<input type="hidden" name="module" value="login"/>
Forgot Password?<br/>
Enter your Email<br/>
<input type="text" name="email"/><br/><br/>
<input type="submit" name="action" value="Retrieve"/><br/><br/>
</form>
</center>
</div>
</div>