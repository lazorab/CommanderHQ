<?php
class RegistergymController extends Controller
{		
    function __construct()
    {
	parent::__construct();
        session_start();
        if(!isset($_COOKIE['UID'])){
            header('location: index.php?module=login');	
        }
    }
  
         function Validate()
        {
            $Message = 'Success';

            if($_REQUEST['AffiliateId'] == '')
                $Message = 'Gym Not Selected!';
		
            return $Message;	
	}
    
    function Message()
    {
        $Message = $this->Validate();
        if($Message == 'Success')
        {
            $Model = new RegisterGymModel;
            $Message = $Model->Register();
        }
        return $Message;
    }   
    
        function Output()
        {
            $Model = new RegisterGymModel; 
            $Affiliates = $Model->getAffiliates($_REQUEST['q']);
            $Json = array();
            foreach($Affiliates AS $Affiliate){
                $Json[] = $Affiliate;
            }
            return ''.$_REQUEST['callback'].'('.json_encode($Json).');';
        }    
}
?>