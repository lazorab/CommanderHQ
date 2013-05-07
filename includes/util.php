<?php

$Request = new BRequest();	
$RENDER = new Image();
$Device = new DeviceManager();

if(FORCEMOBILE){
    define('SCREENWIDTH',320);
}else if($Device->GetScreenWidth() > 640){
    define('SCREENWIDTH',640);
}else if($_REQUEST['orientation'] == 'landscape' && $_SESSION['orientation'] == 'portrait'){
    $_SESSION['orientation'] = 'landscape';
    $properties = $Device->GetDeviceAtlasProperties();
    define('SCREENWIDTH',$properties['displayHeight']);    
}else if($_REQUEST['orientation'] == 'portrait' && $_SESSION['orientation'] == 'landscape'){
    $_SESSION['orientation'] = 'portrait';
    define('SCREENWIDTH',$Device->GetScreenWidth());
}else if($_REQUEST['orientation'] == 'landscape'){
    $_SESSION['orientation'] = 'landscape';
    $properties = $Device->GetDeviceAtlasProperties();
    define('SCREENWIDTH',$properties['displayHeight']);
}else if($_REQUEST['orientation'] == 'portrait'){
    $_SESSION['orientation'] = 'portrait';
    define('SCREENWIDTH',$Device->GetScreenWidth());
}else if($_SESSION['orientation'] == 'landscape'){
    $properties = $Device->GetDeviceAtlasProperties();
    define('SCREENWIDTH',$properties['displayHeight']);
}else if($_SESSION['orientation'] == 'portrait'){
    define('SCREENWIDTH',$Device->GetScreenWidth());
}else{
    define('SCREENWIDTH',$Device->GetScreenWidth());
}
if (SCREENWIDTH < 641) {
    define('LAYOUT_WIDTH','640');
}else if(SCREENWIDTH < 981){
    define('LAYOUT_WIDTH','980');
}else{
    define('LAYOUT_WIDTH','1024');
}
define('IMAGE_RENDER_PATH',''.THIS_ADDRESS.'images/'.LAYOUT_WIDTH.'/');
//TRACKS THE REFERRALS FROM SMS LINKS
if(isset($_REQUEST['r']))
{
    $referralID = $_REQUEST['r'];
    $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $SQL = 'UPDATE MemberReferral SET ClickDate = NOW() WHERE MemberReferralID = '.$referralID.'';
    $db->setQuery($SQL);
    $db->Query();
}
?>
