<?php

define("QA", true);

define('ERROR_REPORT_SITE_NAME', 'Cross Fit Live');
define('ERROR_REPORT_EMAIL_ADDRESS', 'support@be-mobile.co.za');

if (QA) {
    define('TEST_EMAIL', 'devguru@be-mobile.co.za');
    define("THIS_ADDRESS", "http://crossfit.be-mobile.co.za");
} else {
    define('TEST_EMAIL', '');
    define("THIS_ADDRESS", "");
}

/* Production Database Settings */
define("DB_USERNAME", "bemobile");
define("DB_PASSWORD", "cyBerman2010");
define("DB_SERVER", "localhost");
define("DB_CUSTOM_DATABASE", "bemobile_CrossFit");

/* Production Asset Database Settings */
define("DB_ASSET_USERNAME", "bemobile");
define("DB_ASSET_PASSWORD", "cyBerman2010");
define("DB_ASSET_SERVER", "localhost");
define("DB_ASSET_DATABASE", "bemobile_Asset");

/* AD Server Settings */
define('AD_SERVER_URL', 'http://localhost/adhere-adserver/www/delivery/requestad.php');
define('AD_SERVER_OPERATOR_ID', '1');
define('AD_SERVER_OPERATOR_PASSWORD', 'djbj0011');

/* Global Pages */
define('GLOBAL_PAGES', '../../global/pages/');

/* Asset URL */
$handset = new DeviceManagerTest;
if($handset->IsSmartPhone()){
	define('SMARTPHONE', true);
}
else{
	define('SMARTPHONE', false);	
}
define('ASSET_URL', 'http://www.be-mobile.co.za/framework/img_test.php?account_id=5&amp;disp=1&amp;meta=~~meta~~&amp;site_width=');

define('ASSET_API_URL', 'http://asset.be-mobile.co.za/api/');

/* Image Direct */
define('IMAGE_DIRECT', 'http://www.be-mobile.co.za/framework/img_direct_test.php');

/* Site Settings */
define("SITE_ID", "53");
define("DEFAULT_SITE_LANGUAGE", "1");
define("PAGE_SIZE", "5");
define("MAX_PAGES_PAGER", "10");
define("PAGE_WIDTH", "200");
define("IMAGE_WIDTH", "500");
define("DEFAULT_COUNTRY", "28");
define("ADMIN_EMAIL", "admin@be-mobile.co.za");
define("GLOBAL_LIBRARY_VERSION", "2_0");
define("GOOGLE_MAPS_API_KEY", "ABQIAAAAhWg9Osci8ADE7wgndz1-tRQu5cMJyciUnRwVmyUixtQ9oBrzgRRitR-UH4XHaq1EP78URvCaZ3KBmw");

define("EnquiryEmailAddress","devguru@be-mobile.co.za");

/* Status codes */
define('ACTIVE', '1');
define('INACTIVE', '0');

/* End-to-End SMS Settings */
define('SMS_SCRIPT_PATH', '/home/bemobile/public_html/scripts/end-to-end/sms.php');
//define ( 'SMS_SCRIPT_PATH', '' );
define('SMS_USER_NAME', '22186');
define('SMS_PASSWORD', 'emkay1');
define('SMS_FROM_NUMBER', '34743');
/* Global account */
define('CUSTOMER_ACCOUNT_NUMBER', '1982');
define('CUSTOMER_ACCOUNT_ID', '5');
define('CUSTOMER_ACCOUNT_PASSWORD', 'cyBerman2010');

define('DEFAULT_SUB_NUMBER', '+27760000000');
?>
