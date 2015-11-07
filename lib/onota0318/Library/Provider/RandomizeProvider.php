<?php
/**
 * @buief ランダム管理
 * @details
 *   ランダム管理
 *
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Library\Provider;

final class RandomizeProvider
{
    public function setFixedValue($value)
    {
        
    }
    
    public function setFixedInt($int)
    {
        
    }
    
    public function getValue($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
    
    public function getInt($lower, $upper)
    {
        return mt_rand($lower, $upper);
    }
}