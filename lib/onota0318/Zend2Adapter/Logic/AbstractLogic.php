<?php
/**
 * @buief ビジネスロジック（Service層）の基底
 * @details 
 *   LogicDelegatorによってインスタンス生成や実行が行われる
 *
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Logic;

abstract class AbstractLogic
{
    /**
     * バリデーション
     * 
     * @return void
     * @throws ApplicationError
     */
    abstract public function validate();
    
    /**
     * ロジックの実行
     * 
     * @return void
     * @throws ApplicationError
     */
    abstract public function execute();
}
