<?php
/**
 * @buief DB Adapter管理＆提供
 * @details DB Adapter管理＆提供クラス
 *   PHPUnit問題の対策＆マルチDB対策用
 *   
 * @since 2014.12
 * @package Onota0318
 * @see http://ngyuki.hatenablog.com/entry/2013/10/06/212553
 */
namespace Onota0318\Zend2Adapter\Model;

use Zend\Db\Adapter\Adapter;

class SharedAdapterProvider
{
    /**
     * @var string デフォルトキー
     */
    const DEFAULT_KEY = "adapter:default";
    
    /**
     * @var Adapter アダプタ 
     */
    private static $adapter = null;

    /**
     * アダプタがあるか？
     * 
     * @param $key キー
     * @return boolean true あり false なし
     */
    public static function has($key = self::DEFAULT_KEY)
    {
        return isset(self::$adapter[$key])
                && self::$adapter[$key] instanceof Adapter;
    }
    
    /**
     * DBアダプタをセットする。
     * 
     * @param Adapter $adapter アダプタ
     * @param $key キー
     */
    public static function set(Adapter $adapter, $key = self::DEFAULT_KEY)
    {
        self::$adapter[$key] = $adapter;
    }

    /**
     * DBアダプタを取得する。
     * 
     * @param $key キー
     * @return Adapter アダプタ
     */
    public static function get($key = self::DEFAULT_KEY)
    {
        return self::$adapter[$key];
    }
}