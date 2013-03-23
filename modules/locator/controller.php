<?php
class LocatorController extends Controller
{       
    var $Directions;
    var $GPS_Points;
    var $GPS_Start;
    var $GPS_End;
    
	function __construct()
	{
            parent::__construct();
            session_start();
            if(!isset($_COOKIE['UID'])){
                header('location: index.php?module=login');	
            }
            if(isset($_REQUEST['Id'])){
                $this->getMap();
            }
	}
        
        function getMap()
        {
            $Model = new LocatorModel;
            $Affiliate=$Model->getAffiliate($_REQUEST['Id']);
            $Origin=''.$_REQUEST["lat"].','.$_REQUEST["lng"].'';
            $URL='http://maps.googleapis.com/maps/api/directions/xml?origin='.$Origin.'&destination='.$Affiliate->Longitude.','.$Affiliate->Latitude.'&sensor=true';
 //echo $URL;
$params='';
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_TIMEOUT, 180);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
$data=curl_exec($ch);
curl_close($ch);

$xml = new SimpleXMLElement($data);
$dir='';
$i=0;	
$gps_pos=array();


$str='<br/><br/>';
foreach($xml as $step)
{
foreach($step as $loc)
{
foreach($loc as $gps)
{

//print_r($gps);
if($gps->start_location->lat != ''){

if($dir!='')
$dir.='|';
$str.=$gps->html_instructions;
$str.='<br/>';
array_push($gps_pos,''.$gps->start_location->lat.','.$gps->start_location->lng.'');
$i++;
$dir.=''.$gps->start_location->lat.','.$gps->start_location->lng.'';
}
}
}
}
$first=$gps_pos[0];
$last=$gps_pos[$i-1];

$html.='
<script type="text/javascript">
$("#map_canvas").addClass("active");
$("#map_canvas").html("<br/><br/><center>Retrieving map data...</center>");
var latlng1 = new google.maps.LatLng('.$first.');
var latlng2 = new google.maps.LatLng('.$last.');
var myOptions = {
        zoom: 13,
        center: latlng2,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
var LatLong=new google.maps.LatLng();
var map1 = new google.maps.Map(document.getElementById("map_canvas"),
myOptions);
var marker1 = new google.maps.Marker({
        position: latlng1,
        map: map1,
        title: "A"
    });
var marker2 = new google.maps.Marker({
        position: latlng2,
        map: map1,
        title: "Z"
    });
var points = new Array();';
foreach($gps_pos AS $key => $val){
 $html.='points.push(new google.maps.LatLng('.$val.'));';
}
$html.='
var polyline = new google.maps.Polyline({
        path: points,
        map: map1,
        strokeColor: "#034693",
        strokeOpacity: 0.8,
        strokeWeight: 2
    });
</script>';

$html.= $str;
return $html;
                                
        }
        
        function Output()
	{
            $html='';
            $Overthrow='';
            $Device = new DeviceManager;
            if($Device->IsGoogleAndroidDevice()) {
                $Overthrow='class="overthrow"';
            }
            if(isset($_REQUEST['keyword'])){
                $Model = new LocatorModel;
                $Affiliates=$Model->getAffiliatesFromSearch();
                if(count($Affiliates) > 0){
                    $html.='<div '.$Overthrow.'>';
                    $html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';               
                    foreach($Affiliates AS $Affiliate){
                        $html .= '<li>';
                        $html .= '<a href="" onclick="getDetails('.$Affiliate->AffiliateId.');">'.$Affiliate->GymName.':<br/><span style="font-size:small">'.$Affiliate->Region.'</span></a>';
                        $html .= '</li>';
                    }
                    $html .= '</ul><div class="clear"></div><br/></div>';
                }
                else{
                    $html='No Affiliate Gyms match your search';
                }
            }
            else if(isset($_REQUEST['Id'])){
    
                $html.=$this->getMap();
    
            }
            else{
                if(isset($_REQUEST['latitude']) && isset($_REQUEST['longitude'])){
                    if($_REQUEST['latitude'] == null || $_REQUEST['longitude'] == null){
                        $html = 'Cannot determine your present location';
                    }
                    else{
        
                $Model = new LocatorModel;
                $Affiliates=$Model->getAffiliates();
                if(count($Affiliates) > 0){
                    $html.='<div '.$Overthrow.'>';
                    $html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';               
                    foreach($Affiliates AS $Affiliate){
                        $html .= '<li>';
                        $html .= '<a href="" onclick="getDetails('.$Affiliate->AffiliateId.');">'.$Affiliate->GymName.':<br/><span style="font-size:small">'.$Affiliate->Region.'</span></a>';
                        $html .= '</li>';
                    }
                    $html .= '</ul><div class="clear"></div><br/></div>';
                }
                else{
                    $html='No Affiliate Gyms near your present location';
                }
                    }
            
                }
            }
            return $html;
	}
        
 	function TopSelection()
	{
            $validate = new ValidationUtils;
            $Model = new LocatorModel;
            $Affiliate=$Model->getAffiliate($_REQUEST['topselection']);
            $Html = '<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                <li><a href="'.$Affiliate->URL.'" target="_blank">'.$Affiliate->GymName.'</a></ul>';
                $Html.='<br/>
                '.$Affiliate->Address.'<br/>
                '.$Affiliate->Region.'<br/>';
            if($FormattedNumber = $validate->GeneralNumberCheck($Affiliate->TelNo)) {
                $Html.='Tel: <a href="tel:'.$FormattedNumber.'">
                        '.$Affiliate->TelNo.'</a>';
            }    
            return $Html;	
	}       
}
?>