<?php
/**
 * @buief zend2 ロジック動的生成処理
 * @details 
 * [module]/config/module.config.phpで定義
 * コントローラーから呼び出される前提
 * LogicDelegator経由でロジック生成
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Logic;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicAbstractFactory implements AbstractFactoryInterface
{
    /**
     * @var string クラスSAFFIX
     */
    const CLASS_SAFFIX = "Logic";
    
    /**
     * サービスが生成可能か判定する。
     * 
     * @param ServiceLocatorInterface $locator locator
     * @param type $name name
     * @param type $requestedName requestedName
     * @return boolean true：生成可能 false：生成不可
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        return class_exists($requestedName)
            && substr($requestedName, (strlen(self::CLASS_SAFFIX) * -1)) === self::CLASS_SAFFIX;
    }
 
    /**
     * 実体生成処理
     * 
     * @param ServiceLocatorInterface $locator locator
     * @param type $name name
     * @param type $requestedName requestedName
     * @return LogicDelegator ロジック委譲オブジェクト
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        return new LogicDelegator($locator, $requestedName);
    }
}
