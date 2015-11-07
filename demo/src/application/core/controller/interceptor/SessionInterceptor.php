<?php
/**
 * @buief
 * @details zend2 セッション生成用インターセプタ
 * 詳細はAbstractInterceptorに記載
 * 
 * @package core
 * @since 2014.12
 * @see \Onota0318\Zend2Adapter\Controller\Interceptor\AbstractInterceptor
 */

namespace Core\Controller\Interceptor;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\InterceptorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\AbstractInterceptor;
use Onota0318\Environment\AppEnvironment;

class SessionInterceptor extends AbstractInterceptor implements InterceptorInterface
{
    /**
     * @var string プラグイン呼び出し名
     */
    const PLUGIN_CALL_IDENTIFIED = "session";

    /** 
     * {@inheriteDoc}
     */
    public function intercept(AbstractController $instance, ServiceLocatorInterface $locator)
    {
        if (AppEnvironment::getInstance()->isConsole()) {
            return;
        }

        //Actionで使えるようにする
        $instance->getPluginManager()->setInvokableClass(self::PLUGIN_CALL_IDENTIFIED
                ,'Onota0318\Zend2Adapter\Controller\Plugin\SessionPlugin');

        //ハンドラ設定
        $sess = $locator->getServiceLocator()->get('Zend\Session\SessionManager');
        $sess->setSaveHandler($instance->getSessionSaveHandler());
        
        //ハンドラをセット
        $instance->session()->setManager($sess);
    }
}
