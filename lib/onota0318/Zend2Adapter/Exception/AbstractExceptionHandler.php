<?php
/**
 * @buief 例外基底
 * @details 例外基底
 * 設定元はModule.phpのonBootstrapにて
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Exception;

use Zend\Mvc\MvcEvent;

abstract class AbstractExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * {@inheriteDocs}
     */
    abstract public function handle(MvcEvent $e);
    
    /**
     * 原因を文字列化する
     * 
     * @param MvcEvent $e
     * @return string 原因
     */
    protected function toString(MvcEvent $e)
    {
        //TODO
    }
}
