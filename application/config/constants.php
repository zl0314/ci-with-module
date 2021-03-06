<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

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
defined( 'SHOW_DEBUG_BACKTRACE' ) OR define( 'SHOW_DEBUG_BACKTRACE', ENVIRONMENT == 'development' );

/**
 * 站点根目录
 */
define( 'SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR );

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
defined( 'FILE_READ_MODE' ) OR define( 'FILE_READ_MODE', 0644 );
defined( 'FILE_WRITE_MODE' ) OR define( 'FILE_WRITE_MODE', 0666 );
defined( 'DIR_READ_MODE' ) OR define( 'DIR_READ_MODE', 0755 );
defined( 'DIR_WRITE_MODE' ) OR define( 'DIR_WRITE_MODE', 0755 );

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined( 'FOPEN_READ' ) OR define( 'FOPEN_READ', 'rb' );
defined( 'FOPEN_READ_WRITE' ) OR define( 'FOPEN_READ_WRITE', 'r+b' );
defined( 'FOPEN_WRITE_CREATE_DESTRUCTIVE' ) OR define( 'FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb' ); // truncates existing file data, use with care
defined( 'FOPEN_READ_WRITE_CREATE_DESTRUCTIVE' ) OR define( 'FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b' ); // truncates existing file data, use with care
defined( 'FOPEN_WRITE_CREATE' ) OR define( 'FOPEN_WRITE_CREATE', 'ab' );
defined( 'FOPEN_READ_WRITE_CREATE' ) OR define( 'FOPEN_READ_WRITE_CREATE', 'a+b' );
defined( 'FOPEN_WRITE_CREATE_STRICT' ) OR define( 'FOPEN_WRITE_CREATE_STRICT', 'xb' );
defined( 'FOPEN_READ_WRITE_CREATE_STRICT' ) OR define( 'FOPEN_READ_WRITE_CREATE_STRICT', 'x+b' );

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
defined( 'EXIT_SUCCESS' ) OR define( 'EXIT_SUCCESS', 0 ); // no errors
defined( 'EXIT_ERROR' ) OR define( 'EXIT_ERROR', 1 ); // generic error
defined( 'EXIT_CONFIG' ) OR define( 'EXIT_CONFIG', 3 ); // configuration error
defined( 'EXIT_UNKNOWN_FILE' ) OR define( 'EXIT_UNKNOWN_FILE', 4 ); // file not found
defined( 'EXIT_UNKNOWN_CLASS' ) OR define( 'EXIT_UNKNOWN_CLASS', 5 ); // unknown class
defined( 'EXIT_UNKNOWN_METHOD' ) OR define( 'EXIT_UNKNOWN_METHOD', 6 ); // unknown class member
defined( 'EXIT_USER_INPUT' ) OR define( 'EXIT_USER_INPUT', 7 ); // invalid user input
defined( 'EXIT_DATABASE' ) OR define( 'EXIT_DATABASE', 8 ); // database error
defined( 'EXIT__AUTO_MIN' ) OR define( 'EXIT__AUTO_MIN', 9 ); // lowest automatically-assigned error code
defined( 'EXIT__AUTO_MAX' ) OR define( 'EXIT__AUTO_MAX', 125 ); // highest automatically-assigned error code

define( 'MANAGER_PATH', 'Manager' );

/*
|--------------------------------------------------------------------------
| 模块相关配置
|--------------------------------------------------------------------------
*/
define( 'MODULE_NAME', 'modules' );
define( 'MODULE_PATH', APPPATH . MODULE_NAME . DIRECTORY_SEPARATOR );
define( 'MODULE_CONTROLLER', 'Module_Controller' );


/*
|--------------------------------------------------------------------------
| 站点URL
|--------------------------------------------------------------------------
*/
$PHP_SELF = isset( $_SERVER['PHP_SELF'] ) ? $_SERVER['PHP_SELF'] : ( isset( $_SERVER['SCRIPT_NAME'] ) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO'] );
$PHP_SCHEME = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
$PHP_PORT = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
$PHP_PATH = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '/';
define( 'SITE_URL', $PHP_SCHEME . $_SERVER['SERVER_NAME'] . $PHP_PORT );
define( 'SCRIPT_URL', $PHP_SCHEME . $_SERVER['SERVER_NAME'] . $PHP_PORT . $PHP_PATH . ( $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
define( 'SITE_DOMAIN', $_SERVER['SERVER_NAME'] );
define( 'REDIRECT_URL', isset( $_GET['redirect_url'] ) ? urldecode( $_GET['redirect_url'] ) : '' );

/*
|--------------------------------------------------------------------------
| 后台资源路径
|--------------------------------------------------------------------------
*/
define( 'ADMIN_CSS_PATH', '/static/admin/css/' );
define( 'ADMIN_JS_PATH', '/static/admin/js/' );
define( 'ADMIN_IMG_PATH', '/static/admin/images/' );

/*
|--------------------------------------------------------------------------
| 数据库前缀
|--------------------------------------------------------------------------
*/
define( 'DB_PREFIX', 'ci_' );

define( 'HTTP_REFERER', !empty( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '' );

/**
 * 语言开关， 是否多语言
 */
define( 'LANG_ON', true );


/**
 * 微信 公众号
 */
define( 'TK', '3aa67e49024bbfd96e3dedc2353d6f95' ); //TOKEN
define( 'EK', 'aBw0SM3XrDApNCIemcuJ9kY5G2C6T96TnQm5PMxT734' ); //消息加密密钥

define( 'APPID', 'wx6901202603d4cc5c' ); //nice5good=wxce4dd8cf4e8aa782 测试账号=wx6901202603d4cc5c
define( 'APPSEC', '385bc76899052c25b37d9d6a8baadec9' ); //nice5good = f3291de69dffe9391292cfdb8224fe9d 测试=385bc76899052c25b37d9d6a8baadec9
define( 'WECHAT_RESPONSE_TYPE', 2 ); //1 安全加密 2明文

/**
 * 小程序相关
 */
define( 'MINI_P_APPID', 'wxfcb340bece6d3231' );
define( 'MINI_P_APPSEC', '634c9e5cd1067adfd9137d4d144cd7d0');