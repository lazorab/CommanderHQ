<?php

class Controller
{
    	function __construct()
	{
            
        }
        
        function GymDetails()
        {
            $Model= new Model;
            return $Model->getGymDetails();
        }
}
?>