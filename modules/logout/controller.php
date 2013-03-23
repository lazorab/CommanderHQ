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
        setcookie("Username", "", time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
        setcookie("Password", "", time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
        setcookie("UID", "", time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
	header('location: index.php?module=login');
    }
}
?>