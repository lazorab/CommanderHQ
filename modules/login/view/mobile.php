
<script type="text/javascript">

function logmein()
{
    var pass = $('#password').val();
    var user = $('#username').val();
    var r=document.getElementById('remember');
    var remember = '0';
    if(r.checked == true){
        remember = '1';
    }
    $.ajax({url:'ajax.php?module=login&username='+user+'&password='+pass+'&remember='+remember+'',dataType:"html",success:display});
}

function display(message)
{
    if(message != "success")
        alert(message);
    else
        window.location = 'http://<?php echo THIS_DOMAIN;?>/?module=memberhome';
}
</script>

<div id="loginback">
<?php 

if (isset($Display->Message) && strlen($Display->Message) > 0) {?>
	<script language="javascript">
       alert("<?php echo $Display->Message; ?>");
	</script> 
<?php } ?><br/>

<div id="container" style="color:#fff;padding:0 10% 10% 10%">
<br/>
<form action="index.php" id="login" name="login" method="post">
<input type="hidden" name="module" value="login"/>
<input type="text" id="username" name="username" placeholder="Username" data-mini="true" value="<?php echo $_REQUEST['username'];?>"/>
<input type="password" id="password" name="password" placeholder="Password" data-mini="true" value="<?php echo $_REQUEST['password'];?>"/>
<a href="?module=forgot">forgot password?</a>
<br/>

Remember me
<input type="checkbox" id="remember" name="remember" data-role="none" value="yes"
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

<div style="margin:0 10% 0 10%">Login with</div>

<div style="padding:0 5% 0 5%">
<!--
<a href="https://dev.twitter.com/docs/auth/implementing-sign-twitter">
-->
<a href="login-twitter.php" rel="external">
<img alt="Twitter" <?php echo $RENDER->NewImage('twitter.png');?> src="<?php echo IMAGE_RENDER_PATH;?>twitter.png"/></a>
<!--
<a href="https://developers.google.com/accounts/docs/OpenID#settingup">
-->
<a href="gplus_login.php" rel="external">
<img alt="Google" <?php echo $RENDER->NewImage('google.png');?> src="<?php echo IMAGE_RENDER_PATH;?>google.png"/>
</a>
<!--
<a href="http://developers.facebook.com/docs/authentication/server-side/">
-->
<a href="facebook_login.php" rel="external">
<img alt="Facebook" <?php echo $RENDER->NewImage('facebook.png');?> src="<?php echo IMAGE_RENDER_PATH;?>facebook.png"/>
</a>
</div>
</div>
</div>