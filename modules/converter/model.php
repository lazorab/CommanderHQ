<?php
class ConverterModel extends Model
{

    function getMetricValue()
    {
        $ImperialValue = $_REQUEST['imperial'];
        if(!is_numeric($ImperialValue)){
            return 'Must be a number!';
        }else{
        if($_REQUEST['category'] == 'weight'){
            $MetricValue = round($ImperialValue * 0.45, 2);
            $MetricValue .= 'kg';
        }else if($_REQUEST['category'] == 'height'){
            $MetricValue = round($ImperialValue * 2.54, 2);
            $MetricValue .= 'cm';
        }else if($_REQUEST['category'] == 'distance'){
            $MetricValue = round($ImperialValue * 1.61, 2);
            $MetricValue .= 'km';
        }else if($_REQUEST['category'] == 'volume'){
            $MetricValue = round($ImperialValue * 0.03, 2);
            $MetricValue .= 'litres';
        }
        return $MetricValue;
        }
    }
    
    function getImperialValue()
    {
        $MetricValue = $_REQUEST['metric'];
        if(!is_numeric($MetricValue)){
            return 'Must be a number!';
        }else{
        if($_REQUEST['category'] == 1){
            $ImperialValue = round($MetricValue * 2.20, 2);
            $ImperialValue .= 'lbs';
        }else if($_REQUEST['category'] == 2){
            $ImperialValue = round($MetricValue * 0.39, 2);
            $ImperialValue .= 'inches';
        }else if($_REQUEST['category'] == 3){
            $ImperialValue = round($MetricValue * 0.62, 2);
            $ImperialValue .= 'miles';
        }else if($_REQUEST['category'] == 4){
            $ImperialValue = round($MetricValue * 33.81, 2);
            $ImperialValue .= 'oz';
        }
        }
        return $ImperialValue;
    }
}
?>