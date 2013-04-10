
<div id="container">
<div style="font-size:large;color:white"><?php echo $Display->Message;?></div>
<br/><br/>
<div style="width:250px;margin:0 auto 0 auto">
<form action="index.php" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="action" value="Login"/>
<input type="text" name="username" placeholder="Username" data-mini="true"/>
<br/>
<br/>
<input type="password" name="password" placeholder="Password" data-mini="true"/>
<br/>
<br/>
Remember me
<input type="checkbox" id="remember" name="remember" value="yes" data-role="none"/>
<br/>
<br/>
<img onclick="document.login.submit();" alt="Login" src="<?php echo IMAGE_RENDER_PATH;?>login.png"/>
</form>
</div>
<br/>
<br/>
</div>