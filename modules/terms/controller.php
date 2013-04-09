<?php
class TermsController extends Controller
{
    function Message()
    {
        $Model = new TermsModel;
        $Message = $Model->Check();
        
        return $Message;
    }
}
?>