<?php
/**
 * @buief Entity基底
 * @details Entity基底クラス
 * ResultSetで必要なexchangeArrayを実装。
 * ※ArrayObject自体には循環参照時にGCが到達しないバグがある＆もっさり感がある為、
 * 　当クラスはArrayObjectを継承しない。
 * 　バグについては5.5.Xで解消された・・・？？
 *   [○Tableとは循環依存前提]
 * 
 * @since 2014.12
 * @package Onota0318
 * @see https://bugs.php.net/bug.php?id=53803
 */
namespace Onota0318\Zend2Adapter\Model;

use Zend\Db\Adapter\Adapter;
use Onota0318\Library\DateTimer;

abstract class AbstractEntity 
{
    /**
     * @var string キャストアノテーション名
     */
    const CAST_ANNOTATION_NAME = '@castTo';

    /**
     * @var string フィールドアノテーション名
     */
    const COLUMN_ANNOTATION_NAME = '@column';
    
    /**
     * @var Adapter DBアダプタ
     */
    private $adapter = null;
    
    /**
     * @var boolean データ取り込み完了フラグ
     */
    private $isLoaded = false;
    
    /**
     * @var array アクセス不可パラメータ名（本当は動的に処理したかった・・・） 
     */
    protected $denyAccessParams = array(
        "adapter",
        "isLoaded",
    );
    
    /**
     * コンストラクタ
     * ※通常呼び出しNG
     * 空のEntityを生成したいときは、$[table]->loadNewEntity()で生成。
     * 
     * @param Adapter $adapter アダプタ
     * @link [Onota0318\Zend2Adapter\AbstractTable::loadNewEntity()]
     * @deprecated 
     */
    public function __construct(Adapter $adapter)
    {
        $this->isLoaded = false;
        $this->adapter = $adapter;
    }
  
    /**
     * プロパティ呼び出し
     * 
     * @param string $property プロパティ名
     * @return mixed データ
     */
    public function __get($property)
    {
        if (!property_exists($this, $property)) {
            return;
        }
        
        if (in_array($property, $this->denyAccessParams)) {
            return;
        }
        
        return $this->{$property};
    }

    /**
     * プロパティセット
     * Tableオブジェクトのselect結果から取得の場合はセットさせない為、
     * 当メソッドをフックさせる。
     * 
     * @param string $property プロパティ名
     * @param string $value 値
     * @return void
     */
    public function __set($property, $value)
    {
        //すでに読み込み済み→終
        if ($this->isLoaded) {
            //TODO:Exceptionにする
            return;
        }

        if (in_array($property, $this->denyAccessParams)) {
            //TODO:Exceptionにする
            return;
        }
        
        $this->dispose($property, $value);
    }
    
    /**
     * テーブルオブジェクトを取得
     * 
     * @return AbstractTable テーブル
     */
    protected function getTable($fullname)
    {
        $table = new $fullname();
        $table->setDbAdapter($this->adapter);
        
        return $table->initialize();
    }
    
    /**
     * ResultSetで必要なメソッド（ArrayObjectにあるやつ）
     * 当メソッドはTableGateway->select時のResultSetで呼ばれる場合のみ使用可能。
     * ※通常呼び出しNG
     * 
     * @param array $data SELECT結果
     * @return void 
     * @deprecated 
     */
    public function exchangeArray(array $data = array())
    {
        //すでに読み込み済み→終
        if ($this->isLoaded) {
            return;
        }
        
        if (count($data) <= 0) {
            return;
        }

        //プロパティにセット
        $this->disposeParams($data);
        $this->isLoaded = true;
    }
    
    /**
     * データセット
     * 
     * @param array $data ResultSetから受け取ったパラメータ
     * @return void
     */
    private function disposeParams(array $data)
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);
        
        foreach ($properties as $property) {
            $comment = $property->getDocComment();
            $column  = $property->name;
            $value   = null;
            
            if (isset($data[$column])) {
                $value = $data[$column];
            }
            
            //PHPDocコメントなし→ママ代入
            if (false === $comment) {
                $this->dispose($column, $value);
                continue;
            }
    
            //DBフィールド名とプロパティ名が違う（zend2規約によりsnakecaseはNG）
            $columnFromAnnotation = $this->extractColumn($comment);
            if (strlen($columnFromAnnotation) > 0
                    && isset($data[$columnFromAnnotation])) {
                $value = $data[$columnFromAnnotation];
            }
            
            //@castToがあれば変換をかまして代入
            $castTo = $this->extractCastTo($comment);
            if (strlen($castTo) > 0) {
                $this->dispose($column, $this->$castTo($value));
                continue;
            }

            $this->dispose($column, $value);
        }
    }
    
    /**
     * columnアノテーションからデータ抽出
     * 
     * @param string $comment Reflection->getDocCommentの結果
     * @return string 抽出したデータ
     */
    private function extractColumn($comment)
    {
        if (false === strpos($comment, self::COLUMN_ANNOTATION_NAME)) {
            return "";
        }
        
        return $this->extractAnnotationData($comment, self::COLUMN_ANNOTATION_NAME);
    }

    /**
     * castToアノテーションからデータ抽出
     * 
     * @param string $comment Reflection->getDocCommentの結果
     * @return string 抽出したデータ
     */
    private function extractCastTo($comment)
    {
        if (false === strpos($comment, self::CAST_ANNOTATION_NAME)) {
            return "";
        }
        
        $data = $this->extractAnnotationData($comment, self::CAST_ANNOTATION_NAME);
        if (strlen($data) <= 0) {
            return "";
        }
        
        $method = "castTo" . ucfirst($data);
        if (!method_exists($this, $method)) {
            return "";
        }
        
        return $method;
    }

    /**
     * データ抽出
     * 
     * @param string $comment Reflection->getDocCommentの結果
     * @param string $field アノテーション識別子
     * @return string 抽出したデータ
     */
    private function extractAnnotationData($comment, $field)
    {
        $matches = array();
        $pattern = '\\' . $field . '\s.+(\r|\n)'; 
        if (!preg_match("/$pattern/", $comment, $matches)) {
            return "";
        }
        
        return trim(substr($matches[0], strpos($matches[0], " ") + 1));
    }

    /**
     * 日付オブジェクトに変換
     * 
     * @param string $value 変換対象
     * @return DateTimer 日付オブジェクト
     */
    protected function castToDatetime($value = null) 
    {
        if (strlen($value) > 0
                && preg_replace("/[^0-9]/", "", $value) !== str_repeat("0", 14)) {
            return new DateTimer($value);
        }
    }

    /**
     * 真偽値に変換
     * 
     * @param string $value 変換対象
     * @return boolean true / false
     */
    protected function castToBoolean($value = null)
    {
        return (boolean)$value;
    }
    
    /**
     * プロパティにデータセット
     * 
     * @param string $property プロパティ名
     * @param mixed $value セットする値
     */
    protected function dispose($property, $value = null)
    {
        if (in_array($property, $this->denyAccessParams)) {
            //TODO:Exceptionにする
            return;
        }
        
        $this->{$property} = $value;
    }
}
