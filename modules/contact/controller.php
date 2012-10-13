<?php
class ContactController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
    
    function Validate()
    {		
        $Message = 'Success';       
        if($_REQUEST['Comments'] == '')
            $Message = 'Comments are blank!';      
            
        return $Message;
    }
    
     function Message()
    {
        $Model = new ContactModel;
        $Message = $this->Validate();
        if($Message == 'Success')
            $Message = $Model->SendForm();
        
        return $Message;
    }
}
?>