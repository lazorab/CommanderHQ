<?php

$Request = new BRequest();	
$RENDER = new Image();
$Device = new DeviceManager();

define('SCREENWIDTH',$Device->GetScreenWidth());
if (SCREENWIDTH < 641) {
    define('LAYOUT_WIDTH','640');
}else if(SCREENWIDTH < 981){
    define('LAYOUT_WIDTH','980');
}else{
    define('LAYOUT_WIDTH','1024');
}
define('IMAGE_RENDER_PATH',''.THIS_ADDRESS.'images/'.LAYOUT_WIDTH.'/');
//TRACKS THE REFERRALS FROM SMS LINKS
if(isset($request->get['r']))
{
    $referralID = $request->get['r'];
    $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $SQL = 'UPDATE MemberReferral SET ClickDate = NOW() WHERE MemberReferralID = '.$referralID.'';
    $db->setQuery($SQL);
    $db->Query();
}
?>
