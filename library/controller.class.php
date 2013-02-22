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
        
 	function Message()
	{
            $Model= new Model;
            if(isset($_REQUEST['message']))
                return $Model->getMessage();
            else    
                return $Model->getRandomMessage();
	}       
        
        function Gender()
        {
            $Model= new Model;
            return $Model->getGender();
        }
        
        function SystemOfMeasure()
        {
            $Model= new Model;
            return $Model->getSystemOfMeasure();
        }
        
        function UserIsSubscribed()
        {
            $Model= new Model;
            return $Model->UserIsSubscribed();           
        }
        
        function getStopWatch()
        {     
            $Html.='<div class="clear"></div>';
            $Html.='<div id="clock" onClick="EnterTime();">00:00:0</div>';
            $Html.='<input type="hidden" id="TimeToComplete" name="TimeToComplete" value="00:00:0">';
            $Html.='<div class="StopwatchButton"><input id="resetbutton" class="buttongroup" onClick="resetclock();" type="button" value="Reset"/></div>';
            $Html.='<div class="StopwatchButton"><input class="buttongroup" type="button" onClick="Start();" value="Start"/></div>';
            $Html.='<div class="StopwatchButton"><input class="buttongroup" type="button" onClick="Stop();" value="Stop"/></div>';
            $Html.='<input class="buttongroup" type="button" onClick="Save();" value="Save"/>';   

            return $Html;
        }      
}
?>