<?php
/**
 * @buief
 * @details zend2 SSLアクセスのみ許可用インターセプタ
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Core\Controller\Interceptor;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\InterceptorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\AbstractInterceptor;
use Onota0318\Environment\AppEnvironment;
use Onota0318\Exception\NotFoundException;

class HttpsOnlyInterceptor extends AbstractInterceptor implements InterceptorInterface
{
    /** 
     * {@inheriteDoc}
     */
    public function intercept(AbstractController $instance, ServiceLocatorInterface $locator)
    {
        if (AppEnvironment::getInstance()->isHttps()) {
            return;
        }
        
        //SSLじゃなきゃ404エラー
        throw new NotFoundException();
    }
}
