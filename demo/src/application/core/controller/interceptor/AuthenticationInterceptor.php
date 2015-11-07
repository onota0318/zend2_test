<?php
/**
 * @buief
 * @details zend2 認証インターセプタ
 * 
 * @package Onota0318
 * @since 2014.12
 */
namespace Core\Controller\Interceptor;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\InterceptorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\AbstractInterceptor;
use Onota0318\Exception\AuthenticationFailureException;
use Onota0318\Environment\AppEnvironment;

class AuthenticationInterceptor extends AbstractInterceptor implements InterceptorInterface
{
    /**
     * @var string プラグイン呼び出し名
     */
    const PLUGIN_CALL_IDENTIFIED = "authenticate";
    
    /** 
     * {@inheriteDoc}
     */
    public function intercept(AbstractController $instance, ServiceLocatorInterface $locator)
    {
        //初期化
        $this->initPlugin($instance, $locator);
        
        //未認証前提なら終了
        if ($instance instanceof Marker\AuthenticateLoginAware) {
            return;
        }
        
        //未ログイン状態
        if (!$instance->authenticate()->isLogin()) {
            $env = AppEnvironment::getInstance();
            
            $url = $env->base_url . "sample/auth/login?back_url=" 
                 . rawurlencode($env->getServerGlobal("REQUEST_URI"));
            
            $authEx = new AuthenticationFailureException();
            $authEx->setRedirectUrl($url);
            throw $authEx;
        }
    }
    
    /**
     * 認証プラグインの初期化
     * 
     * @param AbstractController $instance
     * @param ServiceLocatorInterface $locator
     */
    private function initPlugin(AbstractController $instance, ServiceLocatorInterface $locator)
    {
        //Actionで使えるようにする
        $instance->getPluginManager()->setInvokableClass(self::PLUGIN_CALL_IDENTIFIED
                ,'Onota0318\Zend2Adapter\Controller\Plugin\AuthenticatePlugin');
        
        $sm     = $locator->getServiceLocator();
        $config = $instance->getAuthenticateConfig();

        $instance->authenticate()->setTableName($config['table']);
        $instance->authenticate()->setConditions($config['conditions']);
        $instance->authenticate()->setIdentityColumn($config['column_id']);
        $instance->authenticate()->setCredentialColumn($config['column_pw']);
        $instance->authenticate()->setDbAdapter($sm->get($config['adapter']));        
    }
}
