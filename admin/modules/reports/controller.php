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
            if($_REQUEST['report'] == 'Registered Athletes'){
                ob_end_clean();                
                echo $this->RegisteredAthletesCSV(); 
                exit();
            }else if($_REQUEST['report'] == 'WOD Results'){
                ob_end_clean();                
                echo $this->CompletedWodsCSV($_REQUEST['athlete']); 
                exit();                
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
            if($Id > 0){
            $Model = new ReportsModel;
            $CompletedWods = $Model->getCompletedWods($Id);
            $Html = '';
            if(count($CompletedWods) == 0){
                $Html.='<option value="">No Completed Daily WODs yet</option>';
            }else{
                $Html.='<option value="0">All WODs</option>';
                foreach($CompletedWods AS $Wod){
                    $Html.='<option value="">'.$Wod->WodName.'</option>';
                }
            }
            }else{
                $Html.='<option value="0">All WODs</option>';
            }
            return $Html;
        }
        
        function RegisteredAthletes()
        {
            $Model = new ReportsModel;
            $RegisteredAthletes = $Model->getRegisteredAthletes();
            $Html = '<select name="athlete" id="athlete" onChange="getWods(this.value);">';
            $Html.='<option value="">Registered Athletes</option>';
            $Html.='<option value="0">All Athletes</option>';
            foreach($RegisteredAthletes AS $Athlete){
                $Html.='<option value="'.$Athlete->UserId.'">'.$Athlete->LastName.', '.$Athlete->FirstName.'</option>';
            }
            $Html.='</select>';
            return $Html;
        }        
        
        function RegisteredAthletesCSV()
        {
            $Model = new ReportsModel;
            $RegisteredAthletes = $Model->getRegisteredAthletes();
            $filename='RegisteredAthletes.csv';

            $fp = fopen('php://output', 'w');
            //$fp = fopen('/Sites/framework/Reports/Commander/RegisteredAthletes.csv', 'w');
            fputcsv($fp, array('MemberID', 'LastName', 'FirstName'));
            foreach($RegisteredAthletes AS $Athlete){
                fputcsv($fp, array($Athlete->UserId, $Athlete->LastName, $Athlete->FirstName));
            }

            fclose($fp);       

            header('Content-type: text/csv');
            header("Content-Disposition: attachment;filename=".$filename."");
        }
        
        function CompletedWodsCSV($Id)
        {
            $Model = new ReportsModel;
            $CompletedGymWods = $Model->getCompletedGymWods($Id);
            $filename='CompletedWods.csv';

            $fp = fopen('php://output', 'w');
            //$fp = fopen('/Sites/framework/Reports/Commander/RegisteredAthletes.csv', 'w');
            fputcsv($fp, array('LastName', 'FirstName', 'WodName', 'Exercise', 'Attribute', 'AttributeValue', 'TimeCompleted'));
            foreach($CompletedGymWods AS $Wod){
                fputcsv($fp, array($Wod->LastName, $Wod->FirstName, $Wod->WodName, $Wod->Exercise, $Wod->Attribute, $Wod->AttributeValue, $Wod->TimeCreated));
            }

            fclose($fp);       

            header('Content-type: text/csv');
            header("Content-Disposition: attachment;filename=".$filename."");
        }        
        
        function RegisteredAthleteCount()
        {
            $Model = new ReportsModel;
            $RegisteredAthleteCount = $Model->getRegisteredAthleteCount();
            return $RegisteredAthleteCount;           
        }        
}
?>
