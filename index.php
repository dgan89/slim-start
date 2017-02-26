<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require 'vendor/autoload.php';

session_start();

ini_set("display_errors",1);
error_reporting(E_ALL);

// Instantiate the app
$settings = require 'config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require 'config/dependencies.php';

// Register middleware
require 'config/middleware.php';

function vd($var)
{
    razmik\helper\VarDumper::vd($var);
}

// Register routes
require 'routes/site.php';
require 'routes/personal.php';
require 'routes/settings.php';
require 'routes/api.php';

// Run app
$app->run();