<?php
class RegistergymController extends Controller
{		
    function __construct()
    {
	parent::__construct();
        session_start();
        if(!isset($_SESSION['UID'])){
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
        $Html = '<form action="index.php" method="post" name="form" id="gymform">
            <input type="hidden" name="form" value="submitted"/>
            <select class="select" name="AffiliateId" id="AffiliateId">
            <option value="">Select your Gym</option>';
        foreach($Affiliates AS $Affiliate){
            $Html.='<option value="'.$Affiliate->AffiliateId.'">'.$Affiliate->GymName.'</option>';
        }
        $Html.='</select>
            <br/><br/>
            <input class="buttongroup" type="button" onclick="gymformsubmit();" value="Save"/>
            </div>
            </form>';
        }
        return $Html;
    }
        
/*    
    function Output()
    {
        $Html='';
        if($_REQUEST['save'] == 'Save'){	
            $Message = $this->Save();
	}
        if($Message != 'Success'){
            $Html .= '<div id="message">' . $Message . '</div>';
        $Html.='<form action="index.php" method="post" name="form" id="gymform">
<div data-role="fieldcontain">
<input type="hidden" name="module" value="registergym"/>
<input type="hidden" name="save" value="Save"/>
<label for="gymname">Gym Name</label>
<input class="textinput" style="width:75%;" type="text" id="gymname" name="gymname" value="'.$_REQUEST['gymname'].'"/><br/>
<label for="country">Country</label>
<input class="textinput" style="width:75%;" type="text" id="country" name="country" value="'.$_REQUEST['country'].'"/><br/>
<label for="region">Region</label>
<input class="textinput" style="width:75%;" type="text" id="region" name="region" value="'.$_REQUEST['region'].'"/><br/>
<label for="tel">Tel</label>
<input class="textinput" style="width:75%;" type="tel" id="tel" name="tel" value="'.$_REQUEST['tel'].'" placeholder="+2778000000"/>
<label for="email">Email</label>
<input class="textinput" style="width:75%;" type="email" id="email" name="email" value="'.$_REQUEST['email'].'"/><br/>
<label for="feedurl">Data Feed URL</label>
<input class="textinput" style="width:75%;" type="text" id="feedurl" name="feedurl" value="'.$_REQUEST['feedurl'].'"/><br/>    
<label for="weburl">Web URL</label>
<input class="textinput" style="width:75%;" type="text" id="weburl" name="weburl" value="'.$_REQUEST['weburl'].'"/><br/>
<br/><br/>
<input class="buttongroup" type="button" onclick="gymformsubmit();" value="Save"/>
</div>
</form>
<br/>';
        }
        else{
            $Html = $Message;
        }
        return $Html;
    }
 * 
 */
}
?>