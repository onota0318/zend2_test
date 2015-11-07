<?php
/**
 * @buief 例外インターフェース
 * @details 例外インターフェース
 * 設定元は各Module.phpのonBootstrapにて
 * 
 * @package Onota0318
 * @since 2014.12
 */
namespace Onota0318\Zend2Adapter\Exception;

use Zend\Mvc\MvcEvent;

interface ExceptionHandlerInterface
{
    /**
     * 例外処理実態
     * 
     * @param MvcEvent $e MvcEvent
     * @return Response レスポンス
     */
    public function handle(MvcEvent $e);
}
