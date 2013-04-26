<?php
class ForgotController extends Controller
{
	
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
    
    function Message()
    {
        $Model = new ForgotModel;
        $Message = $Model->RetrieveDetails();
        return $Message;
    }
}
?>