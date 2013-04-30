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
        
        function Output()
        {
            $Model = new ReportsModel();
            $Html = '';
            if($_REQUEST['report'] == 'Wods'){
                $Html .= $this->getCompletedWods();
            }else if($_REQUEST['report'] == 'Registered Members'){
                $Html .= $this->getMembers();
            }else if($_REQUEST['report'] == 'Activities'){
                $Html .= $this->getCompletedActivities();
            }else if(isset($_REQUEST['WodId'])){
                $Html .= $this->getWodDetails($_REQUEST['WodId']);
            }else{
                $Html .= '<h1>Reports</h1>
    <form action="index.php" name="reports">
    <input type="hidden" name="module" value="reports"/>
    <div id="CountContainer">
    <div class="CountBox" style="border: 2px solid red;">'.$this->RegisteredAthleteCount().'</div>
    <div class="CountBox" style="border: 2px solid blue;">'.$this->CompletedWodCount().'</div>
    <div class="CountBox" style="border: 2px solid green;">'.$this->CompletedActivitiesCount().'</div>
    </div>
    <input type="submit" name="report" value="Registered Members"/>
    <input type="submit" name="report" value="Wods"/>
    <input type="submit" name="report" value="Activities"/>
    </form>';
            }
            return $Html;
        }
        
        function getWodDetails($Id)
        {
            $Model = new ReportsModel;
            $WodDetails = $Model->getWodDetails($Id);
            $Html = '';
            foreach($WodDetails AS $Detail)
            {
                $Html .= $Detail->Exercise;
            }
            return $Html;            
        }
        
        function CompletedActivitiesCount()
        {
            $Model = new ReportsModel;
            $Activities = $Model->getCompletedActivities();
            $Html = count($Activities);
            return $Html;            
        }        
        
        function getCompletedActivities()
        {
            $Model = new ReportsModel;
            $Activities = $Model->getCompletedActivities();
            $Html = '';
            foreach($Activities AS $Activity){
                $Html.=''.$Activity->Exercise.' | '.$Activity->NumberCompleted.'<br/>';
            }
            return $Html;            
        }
        
        function getCompletedWods()
        {
            $Model = new ReportsModel;
            $Wods = $Model->getCompletedWods();
            $Html = '';
            foreach($Wods AS $Wod){
                $Html.='<a href="?module=reports&WodId='.$Wod->WodId.'">'.$Wod->DayName.' Week '.$Wod->WeekNumber.' | '.$Wod->NumberCompleted.'"</a><br/>';
            }
            return $Html;           
        }
        
        function CompletedWodCount()
        {
            $Model = new ReportsModel;
            $Wods = $Model->getCompletedWods();
            $Html = count($Wods);
            return $Html;           
        }        
        
        function getMembers()
        {
            $Model = new ReportsModel;
            $Members = $Model->getRegisteredAthletes();
            $Html = '';
            foreach($Members AS $Member){
                $Html.=''.$Member->FirstName.'<br/>';
            }
            return $Html;
        }
        
        function Message()
        {
            if(isset($_REQUEST['AthleteId'])){
                return $this->CompletedWods($_REQUEST['AthleteId']); 
            }
        }
        
        function CompletedWods($MemberId)
        {
            if($Id > 0){
            $Model = new ReportsModel;
            $CompletedWods = $Model->getCompletedMemberWods($MemberId);
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
        
        function CompletedWodsCSV($MemberId)
        {
            $Model = new ReportsModel;
            $CompletedGymWods = $Model->getCompletedGymWods($MemberId);
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
