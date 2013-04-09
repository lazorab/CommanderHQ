<?php
class ReportsController extends Controller
{
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_COOKIE['GID'])){
                header('location: index.php?module=login');	
            }
	}
        
        function Message()
        {
            if(isset($_REQUEST['AthleteId'])){
                return $this->CompletedWods($_REQUEST['AthleteId']); 
            }
        }
        
        function CompletedWods($Id)
        {
            $Model = new ReportsModel;
            $CompletedWods = $Model->getCompletedWods($Id);
            $Html = '';
            foreach($CompletedWods AS $Wod){
                $Html.='<option value="">'.$Wod->WodName.'</option>';
            }
            return $Html;
        }
        
        function RegisteredAthletes()
        {
            $Model = new ReportsModel;
            $RegisteredAthletes = $Model->getRegisteredAthletes();
            $Html = '<select name="athlete" id="athlete" onChange="getWods(this.value);">';
            $Html.='<option value="">Registered Athletes</option>';
            foreach($RegisteredAthletes AS $Athlete){
                $Html.='<option value="'.$Athlete->UserId.'">'.$Athlete->LastName.', '.$Athlete->FirstName.'</option>';
            }
            $Html.='</select>';
            return $Html;
        }
        
        function RegisteredAthleteCount()
        {
            $Model = new ReportsModel;
            $RegisteredAthleteCount = $Model->getRegisteredAthleteCount();
            return $RegisteredAthleteCount;           
        }        
}
?>
