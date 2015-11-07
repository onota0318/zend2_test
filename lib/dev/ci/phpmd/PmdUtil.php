<?php
/**
 *
 *
 */
namespace Dev\Ci\Phpmd;

class PmdUtil
{
    public static function excludeNamespace($target)
    {
        $tmp = explode("\\", $target);
        return $tmp[count($tmp) - 1];
    }


}