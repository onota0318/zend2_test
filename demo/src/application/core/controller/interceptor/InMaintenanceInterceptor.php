<?php
/**
 * @buief
 * @details zend2 メンテナンス中確認用インターセプタ
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Core\Controller\Interceptor;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\InterceptorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\AbstractInterceptor;
use Onota0318\Exception\MaintenanceException;

class InMaintenanceInterceptor extends AbstractInterceptor implements InterceptorInterface
{
    /** 
     * {@inheriteDoc}
     */
    public function intercept(AbstractController $instance, ServiceLocatorInterface $locator)
    {
        //メンテ中
        //throw new MaintenanceException();
    }
}
