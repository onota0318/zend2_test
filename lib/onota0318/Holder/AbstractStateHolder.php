<?php
/**
 * セッションホルダ基底クラス
 * 
 * @since 2015/01
 * @package Onota0318
 */
namespace Onota0318\Holder;

use Onota0318\Accessor\Accessor;

class AbstractStateHolder extends Accessor
{
    /**
     * IDを取得する。
     *
     * @return string クラス名
     */
    final public static function id()
    {
        return get_called_class();
    }
}
