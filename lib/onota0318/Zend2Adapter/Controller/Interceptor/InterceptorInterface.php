<?php
/**
 * @buief
 * @details zend2 インターセプタ
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Controller\Interceptor;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;

interface InterceptorInterface
{
    /**
     * コントローラーの初期化処理
     * マーカインターフェースにしたがって初期化をする。
     * module.config.phpのcontrollersセクションで定義
     * 
     * @param AbstractController $instance コントローラー
     * @param ServiceLocatorInterface $locator 実際の中身はControllerManager
     * @return void
     */
    public function intercept(AbstractController $instance, ServiceLocatorInterface $locator);
}
