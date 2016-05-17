<?php
/**
 * Config
 *
 * @author David Carr - dave@daveismyname.com
 * @author Edwin Hoksberg - info@edwinhoksberg.nl
 * @version 2.2
 * @date June 27, 2014
 * @date updated Sept 19, 2015
 */

namespace Core;

use Helpers\Session;


class Config
{
    public function __construct()
    {
        ob_start();

        define('SITETITLE', 'My Title');

        define('SESSION_PREFIX', 'et_');
        define('PREFIX', 'et_');
        define('DB_TYPE', 'mysql');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DIR', 'http://enrollment-tool/');


        define('DEFAULT_CONTROLLER', 'welcome');
        define('DEFAULT_METHOD', 'index');
        define('TEMPLATE', 'basic');
        define('LANGUAGE_CODE', 'de');

        define('ENVIRONMENT', 'development');

        set_exception_handler('Core\Logger::ExceptionHandler');
        set_error_handler('Core\Logger::ErrorHandler');
        date_default_timezone_set('Europe/Berlin');
        Session::init();
    }
}
