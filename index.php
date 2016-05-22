<?php
/**
 * SimpleMVC specifed directory default is '.'
 * If app folder is not in the same directory update it's path
 */
$smvc = '.';

/** Set the full path to the docroot */
define('ROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

/** Make the application relative to the docroot, for symlink'd index.php */
if (!is_dir($smvc) and is_dir(ROOT . $smvc)) {
    $smvc = ROOT . $smvc;
}

/** Define the absolute paths for configured directories */
define('SMVC', realpath($smvc) . DIRECTORY_SEPARATOR);

/** Unset non used variables */
unset($smvc);

/** load composer autoloader */
if (file_exists(SMVC . 'vendor/autoload.php')) {
    require SMVC . 'vendor/autoload.php';
}

if (!is_readable(SMVC . 'app/Core/Config.php')) {
    die('No Config.php found, configure and rename Config.example.php to Config.php in app/Core.');
}


if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(E_ALL);
            break;
        case 'production':
            error_reporting(0);
            break;
        default:
            exit('The application environment is not set correctly.');
    }

}

/** initiate config */
new Core\Config();

/** load routes */
require SMVC . 'app/Core/routes.php';
