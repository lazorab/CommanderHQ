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
            }else if(isset($_REQUEST['imperial'])){
                $html.= '<input type="number" name="convert" value="'.$Model->getMetricValue().'"/>';
            }else if($_REQUEST['converter'] == 'Weight'){
                $html.=$this->getWeight();
            }else if($_REQUEST['converter'] == 'Height'){
                $html.=$this->getHeight();
            }else if($_REQUEST['converter'] == 'Volume'){
                $html.=$this->getVolume();
            }else if($_REQUEST['converter'] == 'Distance'){    
                $html.=$this->getDistance();
            }else{    
            $html.='<div style="padding:2%">';
            $html.='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">';
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getConverter(\'Weight\');"><div style="height:26px;width:1px;float:left"></div>Weight<br/><span style="font-size:small"></span></a></li>';             
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getConverter(\'Height\');"><div style="height:26px;width:1px;float:left"></div>Height<br/><span style="font-size:small"></span></a></li>';
            //$html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getConverter(\'Volume\');"><div style="height:26px;width:1px;float:left"></div>Volume<br/><span style="font-size:small"></span></a></li>';
            $html.='<li><a style="font-size:large;margin-top:10px" href="#" onclick="getConverter(\'Distance\');"><div style="height:26px;width:1px;float:left"></div>Distance<br/><span style="font-size:small"></span></a></li>';
            $html.='</ul>';
            $html.='</div>';  

            $html.='<div class="clear"></div><br/>';                
            }
            return $html;
        }
        
        function getWeight()
        {
            $Html='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                    <li>Weight Conversion</li>
                </ul> <br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_weight_input" name="metric_weight" value="" placeholder="Weight in kg"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_weight" name="imperial_weight_answer" value="" placeholder="lbs equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_weight_input" name="imperial_weight" value="" placeholder="Weight in lbs"/>
                <br/><br/><br/>
                </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_weight" name="metric_weight_answer" value="" placeholder="kg equivalent" readonly="readonly"/>
                <br/><br/><br/>
                </div>
                </div>
                <div style="margin:20px 0 0 15px">
                <input class="buttongroup" type="button" name="asubmit" value="Convert" onClick="getConversionValues(\'weight\');"/></div>';
            
            return $Html;            
        }
        
        function getHeight()
        {
            $Html='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                    <li>Height Conversion</li>
		</ul><br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_height_input" name="metric_height" value="" placeholder="Height in cm"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_height" name="imperial_height_answer" value="" placeholder="inch equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_height_input" name="imperial_height" value="" placeholder="Height in inches"/>
                <br/><br/><br/>
                </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_height" name="metric_height_answer" value="" placeholder="cm equivalent" readonly="readonly"/>
                <br/><br/><br/>
                </div>
                </div>	
                <div style="margin:20px 0 0 15px">
                <input class="buttongroup" type="button" name="bsubmit" value="Convert" onClick="getConversionValues(\'height\');"/></div>';
            
            return $Html;            
        }
        
        function getVolume()
        {
            $Html='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                    <li>Volume Conversion</li>
                </ul><br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_volume_input" name="metric_volume" value="" placeholder="Volume in Litres"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_volume" name="imperial_volume_answer" value="" placeholder="Oz equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_volume_input" name="imperial_volume" value="" placeholder="Volume in Oz"/>
                <br/><br/><br/>
                </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_volume" name="metric_volume_answer" value="" placeholder="Litre equivalent" readonly="readonly"/>
                <br/><br/><br/>
                </div>
                </div>	
                <div style="margin:20px 0 0 15px">
                <input class="buttongroup" type="button" name="dsubmit" value="Convert" onClick="getConversionValues(\'volume\');"/></div>';
            
            return $Html;           
        }
        
        function getDistance()
        {
            $Html='<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
			<li>Distance Conversion</li>
		</ul><br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_distance_input" name="metric_distance" value="" placeholder="Distance in km"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_distance" name="imperial_distance_answer" value="" placeholder="mile equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_distance_input" name="imperial_distance" value="" placeholder="Distance in miles"/>
                <br/><br/><br/>
                </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_distance" name="metric_distance_answer" value="" placeholder="km equivalent" readonly="readonly"/>
                <br/><br/><br/>
                </div>
                </div>	
                <div style="margin:20px 0 0 15px">
                <input class="buttongroup" type="button" name="csubmit" value="Convert" onClick="getConversionValues(\'distance\');"/></div>';
            
            return $Html;
        }
}
?>