<?php
/**
 * @buief 列挙型(Map形式)インターフェース
 * @details 列挙型(Map形式)インターフェース
 * 
 * @since 2014
 * @package Onota0318
 */

namespace Onota0318\Type;

interface HashMapInterface
{
    /**
     * 名称変換
     * 
     * @return string 名称
     */
    public function toName();

    /**
     * 連想配列型を返却
     *
     * @return array 配列
     */
    public static function getList();
}
