<?php
/********************************************************
API control
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 24 January 2012

Last Modified Date: 24 January 2012

*********************************************************/
define("DB_USERNAME", "bemobile");
define("DB_PASSWORD", "cyBerman2010");
define("DB_SERVER", "localhost");
define("DB_CUSTOM_DATABASE", "bemobile_CrossFit");

require_once('./library/api.class.php');

if($_REQUEST['action'] == 'WOD')
{
	$API = new API;
	$_DETAILS=array(
		'Description'=>''.$_REQUEST['wod'].'',
		'Duration'=>''.$_REQUEST['dur'].'');	
	$API->InsertWOD($_DETAILS);
}
else
{
	echo 'error';
}
?>
