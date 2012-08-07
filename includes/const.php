<?php

define("QA", true);

define('ERROR_REPORT_SITE_NAME', 'Cross Fit Live');
define('ERROR_REPORT_EMAIL_ADDRESS', 'support@be-mobile.co.za');

if (QA) {
    define('TEST_EMAIL', 'devguru@be-mobile.co.za');
    define("THIS_ADDRESS", "http://qatest6.be-mobile.co.za");
} else {
    define('TEST_EMAIL', '');
    define("THIS_ADDRESS", "");
}

/* Database Settings */
define("DB_CUSTOM_DATABASE", "bemobile_CrossFit");


/* Global Pages */
define('GLOBAL_PAGES', '../../global/pages/');

/* Asset URL */

define('ASSET_URL', 'http://www.be-mobile.co.za/framework/img.php?account_id=5&amp;disp=1&amp;meta=~~meta~~&amp;site_width=');

define('ASSET_API_URL', 'http://asset.be-mobile.co.za/api/');

/* Image Direct */
define('IMAGE_DIRECT', 'http://www.be-mobile.co.za/framework/img_direct.php');
define('ImagePath', '/images/');
    
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
?>
