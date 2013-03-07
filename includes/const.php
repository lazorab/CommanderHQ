<?php

define("QA", true);

define("SUBSCRIPTION", false);

define('FORCEMOBILE',true);

define('HOST','Local');
//define('HOST','Remote');

if(HOST == 'Remote'){
  define('FRAMEWORK_URL','http://framework.be-mobile.co.za'); 
  define('FRAMEWORK_PATH','/Sites/framework'); 
}else{
  define('FRAMEWORK_URL','http://localhost/Framework');  
  define('FRAMEWORK_PATH',''.$_SERVER['DOCUMENT_ROOT'].'/framework'); 
}

define('ERROR_REPORT_SITE_NAME', 'Commander HQ');
define('ERROR_REPORT_EMAIL_ADDRESS', 'support@be-mobile.co.za');

if (QA) {
    define('COMMANDER_EMAIL', 'devguru@be-mobile.co.za');
    define("THIS_DOMAIN", "www.commanderhq.net");
    define("THIS_ADDRESS", "http://www.commanderhq.net/");
} else {
    define('COMMANDER_EMAIL', 'devguru@be-mobile.co.za');
    define("THIS_DOMAIN", "www.commanderhq.net");
    define("THIS_ADDRESS", "http://www.commanderhq.net/");
}

/* Database Settings */
define("DB_CUSTOM_DATABASE", "bemobile_Commander");


define('IMAGE_FILE_PATH', './images');
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

define('DEFAULT_SUB_NUMBER', '+27760000000');
define('SMS_ENABLED', true);
?>
