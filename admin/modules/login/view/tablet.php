<?php echo $Display->Message;?>
<br/><br/>
<form action="index.php" method="post">
<input type="hidden" name="module" value="login"/>
<input type="hidden" name="formsubmitted" value="yes"/>
Username<br/>
<input type="text" name="username"/><br/>
Password<br/>
<input type="password" name="password"/><br/><br/>
<input type="submit" name="submit" value="Submit"/><br/><br/>
Forgot Password?<br/>
Enter your Email<br/>
<input type="text" name="email"/><br/><br/>
<input type="submit" name="submit" value="Retrieve"/><br/><br/>
</form>