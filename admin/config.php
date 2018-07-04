<?php
define('URL_HOME','http://'.$_SERVER['HTTP_HOST'].'/');
define('DIR_HOME',str_replace('\\', '/',dirname(dirname(__FILE__))) ."/");
// HTTP
define('HTTP_SERVER', URL_HOME.'admin/');
define('HTTP_CATALOG', URL_HOME);

// HTTPS
define('HTTPS_SERVER', URL_HOME.'admin/');
define('HTTPS_CATALOG', URL_HOME);

// DIR
define('DIR_APPLICATION', DIR_HOME.'admin/');
define('DIR_SYSTEM', DIR_HOME.'system/');
define('DIR_LANGUAGE', DIR_HOME.'admin/language/');
define('DIR_TEMPLATE', DIR_HOME.'admin/view/template/');
define('DIR_CONFIG', DIR_HOME.'system/config/');
define('DIR_IMAGE', DIR_HOME.'image/');
define('DIR_CACHE', DIR_HOME.'system/storage/cache/');
define('DIR_DOWNLOAD', DIR_HOME.'system/storage/download/');
define('DIR_UPLOAD', DIR_HOME.'system/storage/download');
define('DIR_LOGS', DIR_HOME.'system/storage/logs/');
define('DIR_MODIFICATION', DIR_HOME.'system/storage/modification/');
define('DIR_CATALOG', DIR_HOME.'catalog/');


// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'dangiaoh_dt_user');
define('DB_PASSWORD', 'gj=2tGG4m5+p');
define('DB_DATABASE', 'dangiaoh_daithanh_db');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');