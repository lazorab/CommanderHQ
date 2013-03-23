<?php
class FeedbackController extends Controller
{
    function __construct()
    {
	parent::__construct();	
	session_start();	
    }
    
    function Output()
    {
        if($_REQUEST['Comments'] != ''){
            $Model = new FeedbackModel;
            $Model->SendFeedback();
        }
    }
}
?>