<?php
class ConverterController extends Controller
{
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_SESSION['UID']))
                header('location: index.php?module=login');
	}
        	
        function TopSelection()
	{
            $Form = '<form name="form" action="">';
            if($_REQUEST['topselection'] == 1){
                $Form .= '<input type="number" name="convert" value="" placeholder="Weight"/>';
            }else if($_REQUEST['topselection'] == 2){
                $Form .= '<input type="number" name="convert" value="" placeholder="Height"/>';
            }else if($_REQUEST['topselection'] == 3){
                $Form .= '<input type="number" name="convert" value="" placeholder="Distance"/>';
            }else if($_REQUEST['topselection'] == 4){
                $Form .= '<input type="number" name="convert" value="" placeholder="Volume"/>';
            }
            $Form .= '<input type="button" name="btnsubmit" value=">> Metric" onclick="getMetricValue('.$_REQUEST['topselection'].',convert.value);"/><br/>
                <input type="button" name="btnsubmit" value=">> Imperial" onclick="getImperialValue('.$_REQUEST['topselection'].',convert.value);"/>
                </form>';
            return $Form;	
	}
        
        function Output()
	{
            $Model = new ConverterModel;
            $html='';
            if(isset($_REQUEST['metric'])){
                $html.= '<input type="number" name="convert" value="'.$Model->getImperialValue().'"/>';
            }
            else if(isset($_REQUEST['imperial'])){
                $html.= '<input type="number" name="convert" value="'.$Model->getMetricValue().'"/>';
            }
            return $html;
        }
}
?>