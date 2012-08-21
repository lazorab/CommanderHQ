<?php

class Controller
{
	var $Environment;
	var $SupportOnlineVideo;
	var $Device;
	var $Wall='';
	
	function __construct()
	{
	/*
		$this->Device = new DeviceManager;
		$this->SupportOnlineVideo = $this->Device->SupportOnlineVideo();
		if($this->Device->IsTabletPC()){
				$this->Environment = 'mobile'; //tablet
		}

		elseif($this->Device->GetScreenWidth() < 500){
			if($this->Device->IsSmartPhone()){
				$this->Environment = 'mobile';
			}elseif(!$this->Device->IsSmartPhone()){
				$this->Environment = 'legacy';				
			}
		}
		else
			$this->Environment = 'mobile';	//website
			
		if($this->Environment == 'legacy')
			$this->Wall = 'wall:';	
*/			
	}
	
	function getEnvironment()
	{
		return $this->Environment;
	}	
	
	function RandomMessage()
	{
		$Model= new Model;
		return $Model->getRandomMessage();
	}	
}
?>