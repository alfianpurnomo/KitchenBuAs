<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * Customize definition
 */
define('MAINSITE', 'http://foody.test/');
define('BASE_URL_DEV', 'http://foody.test/');
define('PATH_ROOT', rtrim(str_replace('system', '', str_replace($_SERVER['DOCUMENT_ROOT'], '', BASEPATH)),'/').'/');
define('PATH_ROOT_DOCUMENT', rtrim(str_replace('system', '', BASEPATH),'/').'/');
define('CACHE_PREFIX','makNews_');
define('IMG_UPLOAD_MAX_SIZE', 20480000);
define('FILE_UPLOAD_MAX_SIZE', 20480000);
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'].PATH_ROOT.'/');
define('CMS_UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].PATH_ROOT.'uploads/');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].PATH_ROOT.'uploads/');
//define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].'/uploads/');
define('RELATIVE_UPLOAD_DIR', str_replace($_SERVER['DOCUMENT_ROOT'], '', UPLOAD_DIR));
define('FILE_SYSTEM_ASSETS', 'http://bigtvhd.com/image/system/');
define('IMG_MAX_WIDTH',800);
define('IMG_MAX_HEIGHT',600);
define('IMG_THUMB_WIDTH',400);
define('IMG_THUMB_HEIGHT',400);
define('IMG_MED_WIDTH',208);
define('IMG_MED_HEIGHT',208);
define('IMG_SMALL_WIDTH',90);
define('IMG_SMALL_HEIGHT',90);
// template assets
define('TEMPLATE_DIR','ikkousha');
define('ASSETS_URL', PATH_ROOT.'assets/'.TEMPLATE_DIR.'/');
define('IMG_URL', ASSETS_URL.'img/');
define('UPLOADS_URL', ASSETS_URL.'uploads/');
define('NEWS_IMG_URL', 'uploads/');
define('CSS_URL', ASSETS_URL.'css/');
define('JS_URL', ASSETS_URL.'js/');
define('VENDOR_URL', ASSETS_URL.'vendor/');
define('LIBS_URL', ASSETS_URL.'libs/');
define('SHOW_RECORDS_DEFAULT',10);
// Windows Azure Configuration
define('AZURE_BLOB_PROTOCOL', 'http');
define('AZURE_BLOB_ACCOUNT', 'blobbigtvweb');


//define('AZURE_BLOB_URLPREFIX', AZURE_BLOB_PROTOCOL.'://static1.bigtvhd.com/');
define('AZURE_BLOB_URLPREFIX_ACCOUNT', AZURE_BLOB_PROTOCOL.'://'.AZURE_BLOB_ACCOUNT.'.blob.core.windows.net/');
define('AZURE_BLOB_KEY1', 'Wpnvn5FqB0GcScRV+jdlS08OTNLsHSc5gxnswpVs39wcR2s+O/CuPmJypc3lhDxTUu33lu5WMBL3wvOsD0JYCw==');
define('AZURE_BLOB_KEY2', 'hndBie7kfrUhZqEFmwSGsbE56DUtQWbBwn9gqmhdiVKSH+yBV63oHSIF35joKZBs3tA2mhg/zjV/GbTmHtds4w==');
define('AZURE_FOLDER_UPLOADS','uploads');
define('AZURE_FOLDER_PRABAYAR','prabayar');
define('AZURE_FOLDER_STATIC','static');
define('AZURE_FOLDER_CV','vitae');
define('AZURE_FOLDER_CUSTOMER','customer');
define('AZURE_FOLDER_IMAGE','img');
define('AZURE_FOLDER_CHANNEL','channel');
define('AZURE_FOLDER_MOVIE','movie');
define('AZURE_FOLDER_MAGZ','magz');
define('AZURE_FOLDER_GALLERY','gallery');

//local upload
define('LOCAL_BLOB_URLPREFIX', 'http://muh.dev/');
define('LOCAL_FOLDER_UPLOADS','uploads');
define('LOCAL_FOLDER_IMAGE','img');

// PAYMENT METHOD CONFIG
// development
/*define('DOKU_MALL_ID', '93');
define('DOKU_PUBLIC_KEY', '6XdFHl31vaX8');
define('DOKU_URL_ACTION', 'http://103.10.129.17/Suite/Receive');
define('CIMB_MERCHANT_CODE', 'IF00081_S0001');
define('CIMB_MERCHANT_KEY', 'RRAK4yYCEy');
define('CIMB_STR', CIMB_MERCHANT_KEY.CIMB_MERCHANT_CODE);
define('CIMB_URL_ACTION', 'https://payment.e2pay.co.id/epayment/entry.asp');*/
// production
define('DOKU_MALL_ID', '141');
define('DOKU_PUBLIC_KEY', '75Pi0aDrFBc0');
define('DOKU_URL_ACTION', 'https://pay.doku.com/Suite/Receive');
define('CIMB_MERCHANT_CODE', 'IF00081_S0001');
define('CIMB_MERCHANT_KEY', 'RRAK4yYCEy');
define('CIMB_STR', CIMB_MERCHANT_KEY.CIMB_MERCHANT_CODE);
define('CIMB_URL_ACTION', 'https://payment.e2pay.co.id/epayment/entry.asp');

// soap config
// production
define('SOAP_URL', 'http://139.0.22.186/bigtvwebservice/service.asmx?wsdl');
define('SOAP_TOPUP_URL', 'http://192.168.6.100/ITB/webservice/server2.php?wsdl');
// development
//define('SOAP_URL', 'http://139.0.22.187/BIGTVTESTWEBSERVICE/service.asmx?wsdl');
//define('SOAP_TOPUP_URL', 'http://139.0.22.190/ITB/webservice/server2.php?wsdl');

// email addresses
// development
/*define('FROM_EMAIL', 'no-reply@bigtvhd.com');
define('CUSTOMER_SERVICE_EMAIL', 'socmed.bigtv@gmail.com');
define('ARISAN_EMAIL', 'socmed.bigtv@gmail.com');
define('UPGRADE_PACKAGE_EMAIL', 'socmed.bigtv@gmail.com');
define('DAFTAR_ONLINE_EMAIL', 'socmed.bigtv@gmail.com');
define('VERIFIKASI_ONLINE_EMAIL', 'socmed.bigtv@gmail.com');*/
// production
define('FROM_EMAIL', 'no-reply@bigtvhd.com');
define('ARISAN_EMAIL', 'upgradepaket@gmail.com');
define('UPGRADE_PACKAGE_EMAIL', 'upgradepaket@gmail.com');
define('DAFTAR_ONLINE_EMAIL', 'daftaronlinebigtv@gmail.com');
define('VERIFIKASI_ONLINE_EMAIL', 'verifikasi.online@gmail.com');
define('CUSTOMER_SERVICE_EMAIL', 'customer.service@bigtv.co.id');
