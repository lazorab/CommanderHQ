<?php

class Controller
{
    	function __construct()
	{
            
        }
        
        function SystemOfMeasure()
        {
            $Model= new Model;
            return $Model->getSystemOfMeasure();
        }
}
?>