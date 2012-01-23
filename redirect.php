<?php
error_reporting(E_ERROR | E_PARSE);
require_once("/home/bemobile/public_html/framework/clicks/clicks.class.php");

$siteid=$_REQUEST['site'];
$origin=$_REQUEST['page'];
$item=$_REQUEST['item'];

$action=new ClickRegister;
$url=$action->RegisterClick($siteid,$origin,$item);

header('location:'.$url.'');
?>