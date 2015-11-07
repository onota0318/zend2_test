<?php
/**
 * @buief モジュール
 * @details
 *  モジュール定義
 *  各モジュールの定義情報
 * 
 * @package core
 */

namespace Core;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
use Onota0318\Environment\AppEnvironment;
use Onota0318\Zend2Adapter\Exception\ExceptionHandlerManager;

class Module
{
    /**
     * 
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $event = $e->getApplication()->getEventManager();
        $event->attach(new ModuleRouteListener());

        //例外対応
        $handler = null;
        if (AppEnvironment::getInstance()->isConsole()) {
//            $handler = new \Core\Exception\ConsoleExceptionHandler();
        } else {
            $handler = new \Core\Exception\HttpExceptionHandler();
        }
        
        ExceptionHandlerManager::setDefaultExceptionHandler($handler);
        
        $callback = array($this, 'handleEventError');
        $event->attach(MvcEvent::EVENT_DISPATCH_ERROR, $callback);
        $event->attach(MvcEvent::EVENT_RENDER_ERROR, $callback);
    }
    
    /**
     * 例外のフォワード
     * 
     * @param MvcEvent $e MvcEvent
     * @return Response レスポンス
     */
    public function handleEventError(MvcEvent $e)
    {
        return ExceptionHandlerManager::handle($e);
    }
    
    /**
     * 
     * @return boolean include結果
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @return type
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

}
