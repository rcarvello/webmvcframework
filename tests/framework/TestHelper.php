<?php
$projectRoot = dirname(__DIR__, 2);

if (!defined('RELATIVE_PATH')) {
    define('RELATIVE_PATH', $projectRoot . DIRECTORY_SEPARATOR);
}
if (!defined('SECURING_OUTSIDE_HTTP_FOLDER')) {
    define('SECURING_OUTSIDE_HTTP_FOLDER', '');
}
if (!defined('APP_CONTROLLERS_PATH')) {
    define('APP_CONTROLLERS_PATH', $projectRoot . DIRECTORY_SEPARATOR . 'controllers');
}
if (!defined('APP_MODELS_PATH')) {
    define('APP_MODELS_PATH', $projectRoot . DIRECTORY_SEPARATOR . 'models');
}
if (!defined('APP_VIEWS_PATH')) {
    define('APP_VIEWS_PATH', $projectRoot . DIRECTORY_SEPARATOR . 'views');
}
if (!defined('APP_TEMPLATES_PATH')) {
    define('APP_TEMPLATES_PATH', $projectRoot . DIRECTORY_SEPARATOR . 'templates');
}
if (!defined('APP_LOCALE_PATH')) {
    define('APP_LOCALE_PATH', $projectRoot . DIRECTORY_SEPARATOR . 'locales');
}
if (!defined('JSFRAMEWORK')) {
    define('JSFRAMEWORK', 'framework/js');
}
if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost');
}
if (!defined('SERVER_OS_ENCODING')) {
    define('SERVER_OS_ENCODING', 'UTF-8');
}
if (!defined('DEFAULT_LOGIN_PAGE')) {
    define('DEFAULT_LOGIN_PAGE', 'common/login');
}
if (!defined('DEFAULT_CONTROLLER')) {
    define('DEFAULT_CONTROLLER', 'index');
}
if (!defined('LoginRBACWarningMessage')) {
    define('LoginRBACWarningMessage', 'login-rbac-warning');
}
if (!defined('LoginAuthWarningMessage')) {
    define('LoginAuthWarningMessage', 'login-auth-warning');
}
if (!defined('COMPRESS_OUTPUT')) {
    define('COMPRESS_OUTPUT', false);
}
if (!defined('CHARSET')) {
    define('CHARSET', 'UTF-8');
}
if (!defined('CLASSES')) {
    define('CLASSES', serialize(['framework']));
}
if (!defined('SUBSYSTEMS')) {
    define('SUBSYSTEMS', serialize(['sub']));
}
if (!defined('DBHOST')) {
    define('DBHOST', 'localhost');
}
if (!defined('DBUSER')) {
    define('DBUSER', 'root');
}
if (!defined('DBPASSWORD')) {
    define('DBPASSWORD', '');
}
if (!defined('DBNAME')) {
    define('DBNAME', 'test');
}
if (!defined('STORED_DATE_FORMAT')) {
    define('STORED_DATE_FORMAT', '%Y-%m-%d');
}
if (!defined('STORED_DATETIME_FORMAT')) {
    define('STORED_DATETIME_FORMAT', '%Y-%m-%d %H:%i:%s');
}
if (!defined('USER_TABLE')) {
    define('USER_TABLE', 'users');
}
if (!defined('USER_ID')) {
    define('USER_ID', 'id');
}
if (!defined('USER_EMAIL')) {
    define('USER_EMAIL', 'email');
}
if (!defined('USER_PASSWORD')) {
    define('USER_PASSWORD', 'password');
}
if (!defined('USER_ROLE')) {
    define('USER_ROLE', 'role');
}
if (!defined('USER_SALT')) {
    define('USER_SALT', 'salt');
}
if (!defined('USER_ENABLED')) {
    define('USER_ENABLED', '');
}
if (!defined('USER_TOKEN')) {
    define('USER_TOKEN', 'token');
}
if (!defined('USER_LAST_LOGIN')) {
    define('USER_LAST_LOGIN', 'last_login');
}
if (!defined('CHIPER_CREDENTIALS_COOKIE_SALT')) {
    define('CHIPER_CREDENTIALS_COOKIE_SALT', 'test-salt');
}
if (!defined('APP_LOCALE')) {
    define('APP_LOCALE', 'en');
}
if (!defined('SECURITY_LOGIN_PAGE')) {
    define('SECURITY_LOGIN_PAGE', 'security/login');
}

if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

if (!isset($_SESSION)) {
    $_SESSION = [];
}
if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}