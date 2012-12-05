<?php
class LogoutController extends Controller
{
	function __construct()
	{
		parent:: __construct();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
// Unset Cookies
setcookie("CommanderUsername", "", time()-36000);
setcookie("CommanderPassword", "", time()-36000);
	header('location: index.php?module=login');
	}
}
?>