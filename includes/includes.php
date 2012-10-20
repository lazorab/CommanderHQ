<?php

//include base classes
require_once('/home/bemobile/public_html/global/library/2_0/includes.php');
require_once('/home/bemobile/public_html/framework/general/databasemanager.class.php');
require_once('/home/bemobile/public_html/framework/general/browser.class.php');
require_once('/home/bemobile/public_html/framework/html5coremanager.class.php');
//require_once(''.$_SERVER['DOCUMENT_ROOT'].'/framework/image.class.php');
//require_once(''.$_SERVER['DOCUMENT_ROOT'].'/framework/Paging/paging.class.php');
require_once('/home/bemobile/public_html/framework/globalconst.php');
require_once('/home/bemobile/public_html/framework/SMS/SmsManager.class.php');
require_once('/home/bemobile/public_html/framework/SMS/SendSms.class.php');
require_once('/home/bemobile/public_html/framework/SMS/SmsPortal.class.php');

//include local classes
require_once('./library/request.class.php');
require_once('./library/controller.class.php');
require_once('./library/model.class.php');
require_once('./library/imagecreate.class.php');
require_once('./library/image.class.php');
class utility extends utility_base
{}
require_once('const.php');
require_once('authenticate.php');
?>
