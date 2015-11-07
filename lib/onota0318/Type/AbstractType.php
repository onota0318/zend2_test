<?php
/**
 * @buief 列挙型基底
 * @details 列挙型基底
 * 
 * @since 2014
 * @package Onota0318
 */

namespace Onota0318\Type;

abstract class AbstractType
{
    /**
     * @var string データ
     */
    private $value;

    /**
     * @var array キャッシュ
     */
    private static $cache = array();
    
    /**
     * 未指定の場合のデフォルトを返却
     * 
     * @return string デフォルト値
     */
    abstract protected function __default();

    /**
     * コンストラクタ
     * 
     * @param string $value データ
     */
    public function __construct($value = "")
    {
        if (strlen($value) <= 0
                || !static::has($value)) {
            $value = $this->__default();
        }

        $this->value = $value;
    }

    /**
     * staticなインスタンス生成
     * HogeType::HOGE()みたいな
     * 
     * @param string $label 定数名
     * @param mixed $args 引数
     * @return AbstractType 生成したインスタンス
     */
    final public static function __callStatic($label, $args)
    {
        $class = get_called_class();
        return new static(constant("$class::$label"));
    }

    /**
     * キーが定義済みか？
     * 
     * @param string $key キー
     * @return boolean true:済み false:未
     */
    final public static function hasKey($key)
    {
        $class = get_called_class();
        return defined($class . "::" . $key);
    }

    /**
     * 値が定義済みか？
     * 
     * @param string $value 値
     * @return boolean true:済み false:未
     */
    final public static function has($value)
    {
        return array_key_exists($value, static::toArray());
    }

    /**
     * 列挙データを配列で取得
     * 
     * @return array 配列
     */
    final public static function toArray()
    {
        $class = get_called_class();

        if (!array_key_exists($class, self::$cache)) {
            $consts = (new \ReflectionClass($class))->getConstants();
            self::$cache[$class] = array_flip($consts);
        }
        
        return self::$cache[$class];
    }
    
    /**
     * 値を取り出す
     * 
     * @return string 値
     */
    final public function valueOf()
    {
        return $this->value;
    }

    /**
     * 文字変換
     * @return type
     */
    final public function __toString()
    {
        return (string)$this->value;
    }
}
