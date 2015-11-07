<?php
/**
 * @buief zend2 コントローラー初期化　イベントメソッド追加処理
 * @details preDispatchとpostDispatchイベントがほしかったので
 * 追加すべく・・
 * （こんなことしなくてもできるならそれがよい）
 *
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Controller;

use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttachEventInitializer implements InitializerInterface
{
    /**
     * コントローラーのイベント追加処理
     * 呼び順は以下となる。
     * preDispatch() → onDispatch() → indexAction() → postDispatch()
     * 
     * @param AbstractController $instance コントローラー
     * @param ServiceLocatorInterface $serviceLocator 実際の中身はControllerManager
     * @return void
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        $em = $instance->getEventManager();
        
        //事前処理
        $em->attach(MvcEvent::EVENT_DISPATCH, function($e) use ($instance) {
            if (method_exists($instance, 'preDispatch')) {
                $instance->preDispatch();
            }
        }, 2);
        
        //事後処理
        $em->attach(MvcEvent::EVENT_DISPATCH, function($e) use ($instance) {
            if (method_exists($instance, 'postDispatch')) {
                $instance->postDispatch();
            }
        }, -1);
    }
}
