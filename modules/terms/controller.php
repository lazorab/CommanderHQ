<?php
class TermsController extends Controller
{
    var $Message;
    
    function __Construct()
    {
        if(isset($_REQUEST['TermsAccepted'])){
            $Model = new TermsModel;
            $Message = $Model->Check();
            if($Message == 'Continue')
                header('location: index.php?module=memberhome');
            else
                $this->Message = 'Must accept terms to continue!';
            }   
    }
}
?>