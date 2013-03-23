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
            $Model->Register();
        }
        return $Message;
    }   
    
    function Output()
    {
        $Model = new RegisterGymModel;
        
         if($_REQUEST['form'] == 'submitted'){
            $Html = $Model->Register(); 
        }else{   
            $Affiliates=$Model->getAffiliates();
            $MemberGymId = $Model->getMemberGym();
        $Html = '<form action="index.php" method="post" name="form" id="gymform">
            <input type="hidden" name="form" value="submitted"/>
            <select class="select" name="AffiliateId" id="AffiliateId">
            <option value="">Select your Gym</option>';
        foreach($Affiliates AS $Affiliate){
             $Selected = '';
            if($MemberGymId == $Affiliate->AffiliateId)
                $Selected = 'selected="selected"';           
            $Html.='<option value="'.$Affiliate->AffiliateId.'" '.$Selected.'>'.$Affiliate->GymName.'</option>';
        }
        $Html.='</select>
            <br/><br/>
            <input class="buttongroup" type="button" onclick="gymformsubmit();" value="Save"/>
            </form>';
        }
        return $Html;
    }
}
?>