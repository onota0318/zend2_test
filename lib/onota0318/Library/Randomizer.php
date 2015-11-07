<?php
/**
 * @buief ランダム操作
 * @details
 *   ランダム操作
 *
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Library;

class Randomizer
{
    /**
     * 疑似乱数のバイト文字列を生成
     * 
     * @param integer $length 文字列長
     * @return string 文字列
     */
    public static function getValue($length)
    {
    }
    
    /**
     * 乱数を返却
     * 
     * @param integer $lower 最小値
     * @param integer $upper 最大値（mt_getrandmax）
     * @return integer 乱数
     */
    public static function getInt($lower = 0, $upper = 2147483647)
    {
        if ($upper > mt_getrandmax()) {
            $upper = mt_getrandmax();
        }
    }
}
