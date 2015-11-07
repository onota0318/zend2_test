<?php
return array (
  'router' => 
  array (
    'routes' => 
    array (
      'home' => 
      array (
        'type' => 'Segment',
        'options' => 
        array (
          'route' => '/demo[/:abstract_factory]',
          'constraints' => 
          array (
            'abstract_factory' => '.*',
          ),
          'key_value_delimiter' => '/',
          'param_delimiter' => '/',
          'defaults' => 
          array (
            '__NAMESPACE__' => 'Demo\\Controller',
            'controller' => 'Index',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
      ),
      'sample' => 
      array (
        'type' => 'Segment',
        'options' => 
        array (
          'route' => '/sample[/:abstract_factory]',
          'constraints' => 
          array (
            'abstract_factory' => '.*',
          ),
          'key_value_delimiter' => '/',
          'param_delimiter' => '/',
          'defaults' => 
          array (
            '__NAMESPACE__' => 'Sample\\Controller',
            'controller' => 'Index',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
      ),
    ),
  ),
  'session_config' => 
  array (
    'name' => 'zf2demo',
    'cache_expire' => 100,
    'cookie_domain' => 'fw-demo.localhost',
    'cookie_httponly' => true,
    'cookie_lifetime' => 0,
    'cookie_path' => '/',
    'cookie_secure' => true,
    'use_cookies' => true,
    'cache_limiter' => '',
    'hash_function' => 'sha256',
    'gc_maxlifetime' => 86400,
    'gc_divisor' => 20,
    'remember_me_seconds' => 2419200,
    'use_trans_sid' => true,
  ),
  'db' => 
  array (
    'adapters' => 
    array (
      'adapter:default' => 
      array (
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=demo;host=localhost',
        'driver_options' => 
        array (
          1002 => 'SET NAMES \'UTF8\'',
        ),
        'username' => 'root',
        'password' => '',
      ),
      'adapter:sample' => 
      array (
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=demo;host=localhost',
        'driver_options' => 
        array (
          1002 => 'SET NAMES \'UTF8\'',
        ),
        'username' => 'root',
        'password' => '',
      ),
    ),
  ),
  'service_manager' => 
  array (
    'abstract_factories' => 
    array (
      0 => 'Zend\\Cache\\Service\\StorageCacheAbstractServiceFactory',
      1 => 'Zend\\Log\\LoggerAbstractServiceFactory',
      2 => 'Onota0318\\Zend2Adapter\\Model\\SharedAdapterAbstractFactory',
      3 => 'Onota0318\\Zend2Adapter\\Logic\\LogicAbstractFactory',
    ),
    'factories' => 
    array (
      'HtmlView' => 'Onota0318\\Zend2Adapter\\View\\Smarty\\SmartyStrategyFactory',
      'HtmlViewModel' => 'Onota0318\\Zend2Adapter\\View\\Smarty\\SmartyViewModelFactory',
      'Zend\\Session\\SessionManager' => 'Zend\\Session\\Service\\SessionManagerFactory',
      'Zend\\Session\\Config\\ConfigInterface' => 'Zend\\Session\\Service\\SessionConfigFactory',
    ),
  ),
  'controllers' => 
  array (
    'abstract_factories' => 
    array (
      0 => 'Onota0318\\Zend2Adapter\\Controller\\ControllerAbstractFactory',
    ),
    'initializers' => 
    array (
      0 => 'Onota0318\\Zend2Adapter\\Controller\\AttachEventInitializer',
      1 => 'Onota0318\\Zend2Adapter\\Controller\\Interceptor\\InterceptorInitializer',
    ),
    'interceptor' => 
    array (
      'action' => 
      array (
        'Core\\Controller\\Interceptor\\Marker\\InMaintenanceAware' => 'Core\\Controller\\Interceptor\\InMaintenanceInterceptor',
        'Core\\Controller\\Interceptor\\Marker\\SessionAware' => 'Core\\Controller\\Interceptor\\SessionInterceptor',
        'Core\\Controller\\Interceptor\\Marker\\HttpsOnlyAware' => 'Core\\Controller\\Interceptor\\HttpsOnlyInterceptor',
      ),
      'console' => 
      array (
      ),
    ),
  ),
  'smarty' => 
  array (
    'caching' => false,
    'compile_check' => true,
    'compile_dir' => '/var/www/cgi-bin/demo/resource/cache/smarty/cache/',
    'cache_dir' => '/var/www/cgi-bin/demo/resource/cache/smarty/compile/',
  ),
  'view_manager' => 
  array (
    'strategies' => 
    array (
      0 => 'HtmlView',
      1 => 'ViewJsonStrategy',
    ),
    'display_not_found_reason' => true,
    'display_exceptions' => true,
    'doctype' => 'HTML5',
    'template_path_stack' => 
    array (
      0 => '/var/www/cgi-bin/demo/src/application/demo/config/../view',
      1 => '/var/www/cgi-bin/demo/src/application/sample/config/../view',
    ),
  ),
  'console' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
      ),
    ),
  ),
  'translator' => 
  array (
    'locale' => 'ja_JP',
    'translation_file_patterns' => 
    array (
      0 => 
      array (
        'type' => 'gettext',
        'base_dir' => '/var/www/cgi-bin/demo/config/../resource/language',
        'pattern' => '%s.mo',
      ),
    ),
  ),
);