<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
 *
 * Instagram
 */

$local = "";
$root = "";

defined('IG_CLIENT_ID') OR define('IG_CLIENT_ID', 'd1a16a1571694762a579068848cf9a67');
defined('IG_CLIENT_SECRET') OR define('IG_CLIENT_SECRET', 'c469488648f14bb1b18e7b9e40f84872');
defined('BASE_URL') OR define('BASE_URL', 'http://'. $local .'www.snaggedsocial.com/index.php');
defined('IG_REDIRECT') OR define('IG_REDIRECT', BASE_URL .'/Auth');
defined('IG_TOKEN_REDIRECT') OR define('IG_TOKEN_REDIRECT', 'http://'. $local .'www.snaggedsocial.com/index.php/Auth/getToken');
defined('IG_AUTH_URL') OR define('IG_AUTH_URL', 'https://api.instagram.com/oauth/authorize/?client_id='. IG_CLIENT_ID .'&redirect_uri='. IG_REDIRECT .'&response_type=code');
defined('IG_TOKEN_URL') OR define('IG_TOKEN_URL', 'https://api.instagram.com/oauth/access_token?');
defined('IG_API_URL') OR define('IG_API_URL', 'https://api.instagram.com/v1');
defined('IG_PG_LIMIT') OR define('IG_PG_LIMIT', 20);
defined('IMAGE_INCLUDE') OR define('IMAGE_INCLUDE', $root . '/assets/images/');
defined('JS_INCLUDE') OR define('JS_INCLUDE', $root . '/assets/js/');
defined('CSS_INCLUDE') OR define('CSS_INCLUDE', $root . '/assets/css/');

defined('STRIPE_LIB') OR define('STRIPE_LIB', './application/libraries/stripe/init.php');
defined('STRIPE_PUB_TEST_KEY') OR define('STRIPE_PUB_TEST_KEY', 'pk_test_nJOeAUZgJRAkIAfR8RZh4ME6');
defined('STRIPE_SECRET_TEST_KEY') OR define('STRIPE_SECRET_TEST_KEY', 'sk_test_ieznSEJcIBV5hP1ktzr1WVCV');
defined('STRIPE_PUB_LIVE_KEY') OR define('STRIPE_PUB_LIVE_KEY', 'pk_live_xp6HncKtt0TAQio0MJ5gXUfn');
defined('STRIPE_SECRET_LIVE_KEY') OR define('STRIPE_SECRET_LIVE_KEY', 'sk_live_eCuh1URQWflGRW8wre9LbVjY');

defined('USPS_USER') OR define('USPS_USER', '423SNAGG1254');
defined('USPS_PASS') OR define('USPS_PASS', '816JB11JM432');

defined('MAT_PRICE') OR define('MAT_PRICE', 15.00);
defined('BUSINESS_FEE') OR define('BUSINESS_FEE', 0.05);


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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
