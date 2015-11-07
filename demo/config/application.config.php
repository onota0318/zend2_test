<?php

$env = getenv('APPLICATION_ENV');

use Onota0318\Environment\AppEnvironment;
AppEnvironment::setEnv($env);
AppEnvironment::setConfigFile((__DIR__ . "/env/". AppEnvironment::getEnv() .".properties.ini"));

$isProduction = AppEnvironment::getInstance()->isProduction();

return array(
    // モジュール名
    'modules' => array(
        'Core',
        'Sample',
    ),

    // モジュール名に対する実態のパスマッピング定義
    'module_listener_options' => array(

        //上記[modules]で定義した名称と実態をマッピング
        //オートローディング時の上位名前空間のパス解決をする為のもの
        'module_paths' => array(
            'Core'        => './src/application/core/',
            'Sample'      => './src/application/sample/',
        ),

        //各モジュール間共通の設定
        'config_glob_paths' => array(
            'config/{,*.}{global,local}.php',
        ),

        //configのキャッシュ
        'config_cache_enabled' => $isProduction,
        'config_cache_key'     => "config_cache_key",

        //module_map_cache
        'module_map_cache_enabled' => $isProduction,
        'module_map_cache_key'     => "module_map_cache_key",

        // キャッシュ先
        'cache_dir' => "./resource/cache/zend/",
    ),
);

