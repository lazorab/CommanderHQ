<?php
class LoginController extends Controller {
	var $Message = '';
	function __construct() {
		parent::__construct ();
		$Model = new LoginModel ();
		session_start ();
		if (isset ( $_COOKIE ['UID'] )) {
			header ( 'location: index.php?module=memberhome' );
		}
                if(isset($_REQUEST['username'])){
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
                }
	}
}
?>