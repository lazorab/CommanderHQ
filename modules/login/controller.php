<?php
class LoginController extends Controller {
	var $Message = '';
	function __construct() {
		parent::__construct ();
		$Model = new LoginModel ();
		session_start ();
		if (isset ( $_COOKIE ['UID'] )) {
			header ( 'location: index.php?module=memberhome' );
		} else if ($_REQUEST ['action'] == 'Login') {
			$UserId = $Model->Login ( $_REQUEST ['username'], $_REQUEST ['password'] );
			if (! $UserId) {
				$this->Message = 'Invalid Credentials, Please try again.';
			} else {
				if ($_REQUEST ['remember'] == 'yes' && (! isset ( $_COOKIE ['Username'] ) && ! isset ( $_COOKIE ['Password'] ))) {
					setcookie ( "Username", $_REQUEST ['username'], time () + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false );
					setcookie ( "Password", $_REQUEST ['password'], time () + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false );
				} else if (isset ( $_COOKIE ['Username'] ) && isset ( $_COOKIE ['Password'] )) {
					setcookie ( "Username", "", time () + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false );
					setcookie ( "Password", "", time () + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false );
				}
				setcookie ( 'UID', $UserId, time () + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false );
				header ( 'location: index.php?module=memberhome' );
			}
		} else if ($_REQUEST ['oauth_provider'] == 'twitter') {
			header ( "Location: login-twitter.php" );
		} else if ($_REQUEST ['oauth_provider'] == 'google') {
			header ( "Location: gplus_login.php" );
		} else if ($_REQUEST ['oauth_provider'] == 'facebook') {
			header ( "Location: facebook_login.php" );
		} else if ($_REQUEST ['action'] == 'Retrieve') {
			$Model = new LoginModel ();
			if ($_REQUEST ['username'] == '')
				$this->Message = 'You must enter your Username';
			if ($_REQUEST ['email'] == '')
				$this->Message = 'You must enter your Email Address';
			if ($this->Message == '') {
				$Successful = $Model->RetrievePassword ( $_REQUEST ['username'], $_REQUEST ['email'] );
				if (! $Successful)
					$this->Message = 'Error sending email';
				else
					$this->Message = 'You have been sent an email';
			}
		}
	}
}
?>