<?php
session_start();
$ErrorMessage = '';
if($_REQUEST['submit'] == 'Submit')
{
	$Login = new Login($_REQUEST['username'], $_REQUEST['password']);
	if(!$Login->ReturnValue){
		$ErrorMessage = 'Invalid Login, Please try again.';
	}
	else{
		$_SESSION['UID'] = $Login->ReturnValue;
		header('location: index.php?page=memberhome');
	}
}
elseif($_REQUEST['submit'] == 'Retrieve')
{
	if($_REQUEST['username'] == '')
		$ErrorMessage = 'You must enter your Username';
	if($_REQUEST['email'] == '')
		$ErrorMessage = 'You must enter your Email Address';
	if($ErrorMessage == '')
	{
		$Successful = new Retrieval($_REQUEST['username'], $_REQUEST['email']);
		if($Successful)
			$ErrorMessage = 'You have been sent an email';
		else
			$ErrorMessage = 'Error sending email';
	}
}
echo $ErrorMessage;
?>
<wall:br/><wall:br/>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="page" value="login"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
Username<wall:br/>
<wall:input type="text" name="username"/><wall:br/>
Password<wall:br/>
<wall:input type="password" name="password"/><wall:br/><wall:br/>
<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
Forgot Password?<wall:br/>
Enter your Email<wall:br/>
<wall:input type="text" name="email"/><wall:br/><wall:br/>
<wall:input type="submit" name="submit" value="Retrieve"/><wall:br/><wall:br/>
</wall:form>