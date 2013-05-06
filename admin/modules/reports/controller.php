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
            }else if($_REQUEST['Graph'] == 'Wods'){
                $Html .= json_encode($Model->getCompletedWods());
            }else if($_REQUEST['report'] == 'Members'){
                $Html .= $this->getMembers();
            }else if($_REQUEST['report'] == 'Activities'){
                $Html .= $this->getCompletedActivities();
            }else if($_REQUEST['Graph'] == 'Activities'){
                $Html .= json_encode($Model->getCompletedActivities());
            }else if(isset($_REQUEST['WodId'])){
                $Html .= $this->getWodDetails($_REQUEST['WodId']);
            }else{
                $Html .= '<h1>Reports</h1>

    <div id="CountContainer">
    <div class="CountBox" style="border: 2px solid red;"><br/><br/>'.$this->RegisteredAthleteCount().'</div>
    <div class="CountBox" style="border: 2px solid blue;"><br/><br/>'.$this->CompletedWodsCount().'</div>
    <div class="CountBox" style="border: 2px solid green;"><br/><br/>'.$this->CompletedActivitiesCount().'</div>
    </div><div class="clear"></div>
    <div style="height:50px;width:100%"><div class="boxlabel">Active Registered Members</div><div class="boxlabel">Recorded WODs</div><div class="boxlabel">Recorded Activities</div></div>
    <br/>
    <div style="height:50px;width:100%">
    <div class="boxlabel">
    <button onClick="getMembers();">Registered Members</button>
    </div>
    <div class="boxlabel">
    <button onClick="getWods();">WODs</button>
    </div>
    <div class="boxlabel">
    <button onClick="getActivities();">Activities</button>
    </div>
    </div>';
            }
            return $Html;
        }
        
        function getWodDetails($Id)
        {
            $Model = new ReportsModel;
            $WodDetails = $Model->getWodDetails($Id);
            $Html = '<div style="width:100%;height:150px"><div class="CountBox" style="border: 2px solid red;"><span style="font-size:small">Wod Completed</span><br/><br/>'.$Model->getCompletedWodCount($Id).'</div>';
            $Html .= '<div class="CountBox" style="border: 2px solid blue;"><span style="font-size:small">Avg. Time</span><br/><br/>'.$this->AverageWodTime($Id).'</div>';
            $Html .= '</div><div style="width:100%;height:100px"">';
            $Html .= '<div style="float:left">Wod Name: '.$WodDetails[0]->WodName.'</div>';
            $Html .= '<div style="float:right">Wod Date: '.$WodDetails[0]->WodDate.'</div><br/>';
            $Html .= 'Description: '.$WodDetails[0]->Description.'</div>';
            $Exercise = '';
            $Html .= '<div>';
            foreach($WodDetails AS $Detail)
            {
                if($Exercise != $Detail->Exercise){
                $Html .= '</div><div style="width:100%"><div style="float:left;width:30%">'.$Detail->Exercise.'</div><div style="float:left;width:70%">'; 
                    }
                $Html .= ' |  '.$Detail->Attribute.' : '.$Detail->AttributeValueFemale.'(f)  '.$Detail->AttributeValueMale.'(m) ';
                $Exercise = $Detail->Exercise;
            }
            $Html .= '</div></div><br/><button style="float:right" onclick="go(\'?module=reports&report=Wods\');">Back to Completed WODs</button><br/><br/>';
            return $Html;            
        }
        
        function AverageActivityReps($ActivityId)
        {

            $Model = new ReportsModel;
            $ActivityReps = $Model->getAverageActivityReps($ActivityId);
            $TotalReps = 0;
            if(count($ActivityReps) > 0){
                foreach($ActivityReps AS $These){
                    if($These->Reps > 0){
                        $TotalReps = $TotalReps + $These->Reps;
                    }
                }
                $AverageReps = floor($TotalReps / count($ActivityReps));
            }else{
                $AverageReps = 0;
            }
            return $AverageReps;

        }
        
        function AverageActivityWeight($ActivityId)
        {
            
            $Model = new ReportsModel;
            $Weights = $Model->getAverageActivityWeight($ActivityId); 
                           
            return 'Weight';
                       
        }
        
        function AverageActivityTime($ActivityId)
        {
            $Model = new ReportsModel;
            $Times = $Model->getAverageActivityTimes($ActivityId);   
            return $this->CalculateAverageTime($Times);

         
        }
        
        function AverageWodTime($WodId)
        {
            $Model = new ReportsModel;
            $Times = $Model->getAverageWodTimes($WodId);
            return $this->CalculateAverageTime($Times);
        }
         
        function CalculateAverageTime($Times)
        {
            $NumberOfTimes = 0;
            $AverageTime = 0;
            $TotalSeconds = 0;
            foreach($Times AS $time)
            {
                if($time->TimeToComplete != '')
                {
                    $Time = explode(':',$time->TimeToComplete);
                    //$Hours=$Time[0];
                    $Minutes = $Time[0];
                    $Seconds = $Time[1];
                    //$SplitSeconds = $Time[2];
 
                    $TotalSeconds = $TotalSeconds + $Seconds + ($Minutes * 60);  
                    //$TotalSplitSeconds = $TotalSplitSeconds + $SplitSeconds;
                    $NumberOfTimes++;
                }
            }
            if($NumberOfTimes > 0 && $TotalSeconds > 0){
            $AverageSeconds = floor($TotalSeconds / $NumberOfTimes);
            
            $NewTotalMinutes = floor($AverageSeconds / 60);
            $NewTotalSeconds = $AverageSeconds - floor($NewTotalMinutes * 60);

            $AverageTime = ''.$this->number_pad($NewTotalMinutes,2).':'.$this->number_pad($NewTotalSeconds,2).'';
            }

            return $AverageTime;
        }
        
        private function number_pad($number,$n) {
            return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
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
            $Html = '<h2>Completed Activities | No. Activities | Avg. Reps | Avg. Weight | Avg. Time</h2>';
            foreach($Activities AS $Activity){
                if($Activity->NumberCompleted > 0)
                $Html.='<button style="width:100%; text-align:left;"><h2>'.$Activity->Exercise.' | '.$Activity->NumberCompleted.' | '.$this->AverageActivityReps($Activity->ExerciseId).' | '.$this->AverageActivityWeight($Activity->ExerciseId).' | '.$this->AverageActivityTime($Activity->ExerciseId).'</h2></button><br/>';
            }
            return $Html;            
        }
        
        function getCompletedWods()
        {
            $Model = new ReportsModel;
            $Wods = $Model->getCompletedWods();
            $Html = '<h2>Completed WODs | WOD Completed | Avg. Time</h2>';
            foreach($Wods AS $Wod){
                if($Wod->NumberCompleted > 0)
                $Html.='<button style="width:100%; text-align:left;" onclick="go(\'?module=reports&WodId='.$Wod->WodId.'\');"><h2>'.$Wod->DayName.' Week '.$Wod->WeekNumber.' | '.$Wod->NumberCompleted.' | '.$this->AverageWodTime($Wod->WodId).'</h2></button><br/>';
            }
            return $Html;           
        }
        
        function CompletedWodsCount()
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
            $Html = '<h2>Name | WODs Completed | Baseline Time</h2>';
            foreach($Members AS $Member){
                $NumberMemberWods = count($Model->getCompletedMemberWods($Member->UserId));
                $MemberBaselineTime = $Model->getMemberBaselineTime($Member->UserId);
                if($Member->Anon == 0){
                   $MemberName = ''.$Member->FirstName.' '.$Member->LastName.'';
                }else{
                    $MemberName = 'Anon';
                }
                $Html.='<button style="width:100%; text-align:left;" onclick="go(\'?module=reports&MemberId='.$Member->UserId.'\');"><h2>'.$MemberName.' | '.$NumberMemberWods.' | '.$MemberBaselineTime.'</h2></button><br/>';
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
