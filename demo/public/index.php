<?php

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("NAMESPACE_SEPARATOR")) {
    define("NAMESPACE_SEPARATOR", "\\");
    define("NS", NAMESPACE_SEPARATOR);
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

//========================================//
// Ono Orig.
//========================================//
//include_pathから解決
$autoLoader = stream_resolve_include_path("vendor/autoload.php");

//include_pathから解決できない場合・・・
//lib/以下を固定で探す
if (!$autoLoader) {
    $autoLoader = realpath(dirname(__FILE__) . "/../../lib/vendor/autoload.php");

    if (!$autoLoader) {
        throw new Exception("autoloader not found.");
    }
} 

require $autoLoader;
//========================================//

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
