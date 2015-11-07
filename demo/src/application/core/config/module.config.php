<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
$env = \Onota0318\Environment\AppEnvironment::getInstance();

return array(
    'router'         => include __DIR__ . "/router.config.php",
    'session_config' => include __DIR__ . "/session.config.php",
    'db'             => include __DIR__ . "/database.config.php",

    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            'Onota0318\Zend2Adapter\Model\SharedAdapterAbstractFactory',
            'Onota0318\Zend2Adapter\Logic\LogicAbstractFactory',
        ),
        'factories' => array(
            'HtmlView' => 'Onota0318\Zend2Adapter\View\Smarty\SmartyStrategyFactory',
            'HtmlViewModel' => 'Onota0318\Zend2Adapter\View\Smarty\SmartyViewModelFactory',
            'Zend\Session\SessionManager' => 'Zend\Session\Service\SessionManagerFactory',
            'Zend\Session\Config\ConfigInterface' => 'Zend\Session\Service\SessionConfigFactory',
        ),
    ),

    'controllers' => array(
        'abstract_factories' => array(
            'Onota0318\Zend2Adapter\Controller\ControllerAbstractFactory',
        ),

        'initializers' => array(
            'Onota0318\Zend2Adapter\Controller\AttachEventInitializer',
            'Onota0318\Zend2Adapter\Controller\Interceptor\InterceptorInitializer',
        ),

        'interceptor' => include __DIR__ . "/interceptor.config.php",
    ),
    'controller_plugins' => array(
        'invokables' => array(
//            'session'      => 'Onota0318\Zend2Adapter\Controller\Plugin\SessionPlugin',
//            'authenticate' => 'Onota0318\Zend2Adapter\Controller\Plugin\AuthenticatePlugin',
        )
    ),

    'smarty' => array(
        'caching'         => false,
        'compile_check'   => true,
        'compile_dir'     => $env->template_cache_dir,
        'cache_dir'       => $env->template_compile_dir,
    ),

    'view_manager' => array(
        'strategies' => array('HtmlView', 'ViewJsonStrategy'),
        'display_not_found_reason' => !$env->isProduction(),
        'display_exceptions'       => !$env->isProduction(),
        'doctype'                  => 'HTML5',
//        'not_found_template'       => 'error/404',
//        'exception_template'       => 'error/index',
    ),

    'view_helpers' => array(
        'invokables'=> array(
            'errors' => 'Onota0318\Zend2Adapter\View\Helper\ErrorsHelper',
            'env'    => 'Onota0318\Zend2Adapter\View\Helper\EnvHelper',
        )
    ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
