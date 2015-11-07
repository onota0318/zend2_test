<?php
/**
 * Viewホルダ基底クラス
 * 
 * @since 2015/01
 * @package sample
 */
namespace Onota0318\Holder;

use Onota0318\Accessor\Accessor;
use Onota0318\Constants\MasterConstants;

class AbstractScreenHolder extends Accessor
{
    /**
     * IDを生成
     * 
     * @return string ID
     */
    final public static function id()
    {
        $name = get_called_class();
        $tmp  = explode(MasterConstants::NS, $name);
        return $tmp[count($tmp) - 1];
    }
}
