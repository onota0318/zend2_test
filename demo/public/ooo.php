<?php

require_once 'autoload.php';
putenv('APPLICATION_ENV=development');

use Onota0318\Environment\AppEnvironment;


$paths = array(
//    "/var/www/cgi-bin/demo/src/application",
    "/var/www/cgi-bin/",
);

foreach ($paths as $path) {

    $command = "/usr/bin/find $path -type f -name '*.php'";
    exec($command, $res);
    
    if (count($res) <= 0) {
        continue;
    }

    foreach ($res as $file) {
        @include_once $file;
    }
}

