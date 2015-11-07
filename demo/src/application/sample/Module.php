<?php
/**
 * @buief モジュール
 * @details
 *  モジュール定義
 *  各モジュールの定義情報
 * 
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Sample;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\ModuleManager;
use Onota0318\Zend2Adapter\Exception\ExceptionHandlerManager;

class Module
{
    /**
     * モジュールのブーター
     * 
     * @param MvcEvent $e MvcEvent
     */
    public function onBootstrap(MvcEvent $e)
    {
        $event = $e->getApplication()->getEventManager();
        $event->attach(new ModuleRouteListener());

        //モジュール別例外定義
        $handler = new \Sample\Exception\HttpExceptionHandler();
        ExceptionHandlerManager::setExceptionHandler(__NAMESPACE__, $handler);
    }

    /**
     * モジュールの初期化
     * @param ModuleManager $moduleManager ModuleManager
     */
    public function init(ModuleManager $moduleManager) 
    {
        /* @buief
         * viewのtemplate_path_stackをここで定義。
         * module.config定義だと別モジュール同テンプレ名を拾ってしまう為。
         */
        $current = $this->getRootPath();
        $shared  = $moduleManager->getEventManager()->getSharedManager();
        
        $shared->attach(__NAMESPACE__, 'dispatch', function($e) use ($current) { 
            $sm = $e->getApplication()->getServiceManager(); 
            $resolver = $sm->get('Zend\View\Resolver\TemplatePathStack'); 
            $resolver->setPaths(array($current . '/view/'));
        }, 100); 
    }
    
    /**
     * 
     * @return boolean include結果
     */
    public function getConfig()
    {
        return include $this->getRootPath() . '/config/module.config.php';
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
                    __NAMESPACE__ => $this->getRootPath(),
                ),
            ),
        );
    }

    /**
     * ルートパスを返却
     * 
     * @return string ルートディレクトリ
     */
    public function getRootPath()
    {
        return dirname(__FILE__);
    }
}
