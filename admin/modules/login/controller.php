<?php
class LoginController extends Controller
{
	var $Message='';
	
	function __construct()
	{
		$Model = new LoginModel();
		session_start();
		if(isset($_COOKIE['GID'])){
			header('location: index.php?module=upload');	
		}
		else if($_REQUEST['action'] == 'Login')
		{
			$GymId = $Model->Login($_REQUEST['username'], $_REQUEST['password']);	
			if(!$GymId){
				$this->Message = 'Invalid Credentials, Please try again.';
			}
			else{
				if($_REQUEST['remember'] == 'yes'){
					setcookie("AdminUsername", $_REQUEST['username'], time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
					setcookie("AdminPassword", $_REQUEST['password'], time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);
				}
                                setcookie('GID', $GymId, time() + (20 * 365 * 24 * 60 * 60), '/', THIS_DOMAIN, false, false);

				header('location: index.php?module=upload');
			}		
		}	
		else if($_REQUEST['action'] == 'Register')
		{
			$Model = new LoginModel();
			$Model->Register();
		}
        }
                
                function Output()
                {
                  if($_REQUEST['action'] == 'getAffiliates')
		{
			$Model = new LoginModel();
			$Affiliates = $Model->getAffiliates();

                        return json_encode($Affiliates);
		}                   
                }
		
}
?>