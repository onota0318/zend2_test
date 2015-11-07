<?php
/**
 * 汎用アクセサ
 *
 * 同名のメソッドがあったらそれを優先して呼び出し、なかったらプロパティの値を返す
 */
namespace Onota0318\Accessor;

abstract class Accessor
{
    /**
     * @var string getter接頭子
     */
    const GETTER_PREFIX = "get";

    /**
     * @var string setter接頭子
     */
    const SETTER_PREFIX = "set";

    /**
     * @var boolean プロパティにセット可能か？ 
     */
    private $isSettable = true;
    
    /**
     * 任意のIDを取得する
     * @return string id
     */
    public static function id()
    {
        return get_called_class();
    }
    
    /**
     * コンストラクタ
     *
     * @param array $options 初期値
     */
    public function __construct(array $options = array())
    {
        foreach ($options as $key => $value) {

            $method   = self::SETTER_PREFIX . $this->makeCamelCase($key);
            $property = $key;

            if (method_exists($this, $method)) {
                $this->$method($value);
            }

            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * セッター禁止令
     * @return void
     */
    public function disablePropertySet()
    {
        $this->isSettable = false;
    }
    
    /**
     * Magic Function
     * 同名のメソッドがあったらそれを優先して呼び出し、
     * なかったらプロパティの値を返す
     *
     * @param string $name プロパティ名
     *
     * @return string 値
     */
    public function __get($name)
    {
        $method   = self::GETTER_PREFIX . $this->makeCamelCase($name);
        $property = $name;

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * Magic Function
     * 同名のメソッドがあったらそれを優先して呼び出し、
     * なかったらプロパティにセット
     *
     * @param string $name  プロパティ名
     * @param mixed  $value 値
     * 
     * @throws \LogicException
     */
    public function __set($name, $value)
    {
        if (!$this->isSettable) {
            throw new \LogicException(
                 "プロパティへのデータセット禁止です。 "
                ."プロパティ[". $name ."] "
                ."値[". $value ."] "
            );
        }
        
        $method   = self::SETTER_PREFIX . $this->makeCamelCase($name);
        $property = $name;

        if (method_exists($this, $method)) {
            $this->$method($value);
            return;
        }

        if (property_exists($this, $property)) {
            $this->$property = $value;
            return;
        }
    }

    /**
     * 名前をキャメルケースに変換
     * 先頭と各アンダーバーの後の1文字を大文字に変換し、アンダーバーを削除。
     *
     * @param string $name プロパティ名
     *
     * @return string 変換後プロパティ名
     */
    private function makeCamelCase($name)
    {
        $names = explode("_", $name);
        $count = count($names);
        $camelcase = "";

        for ($iii = 0; $iii < $count; ++$iii) {
            $camelcase .= ucfirst($names[$iii]);
        }

        return $camelcase;
    }
}
