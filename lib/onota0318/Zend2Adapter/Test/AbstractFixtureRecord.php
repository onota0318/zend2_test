<?php
/**
 * @buief Fixtureレコード基底
 * @details Fixtureレコード基底
 * FixtureManagerに渡す為のオブジェクト
 * 
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Zend2Adapter\Test;

abstract class AbstractFixtureRecord
{
    /**
     * @var string 使用するテーブル名 
     */
    protected $tableName = "";
    
    /**
     * テーブル名を取得する。
     * @return string テーブル名
     */
    public function getTableName()
    {
        if (strlen($this->tableName) <= 0) {
            throw new \LogicException(
                "テーブル名定義がありません！"
            );
        }
        
        return $this->tableName;
    }

    /**
     * レコードを取得する。
     * 
     * @return array レコード
     * @throws \LogicException
     */
    public function getRecords()
    {
        $records = $this->records();
        
         if (count($records) <= 0) {
            throw new \LogicException(
                "レコード定義が正しくありません！"
            );
        }
        
        return $records;
    }
    
    /**
     * フィールドリストを取得
     * 
     * @return array フィールドリスト
     */
    public function getFields()
    {
        $records = $this->getRecords();
        return array_keys($records[0]);
    }
    
    /**
     * レコードを定義
     * 例）
     *    return array(
     *      //1レコード目
     *      array(
     *         "id" => 1,
     *         "name" => "太郎１",
     *      ),
     *      //2レコード目
     *      array(
     *         "id" => 2,
     *         "name" => "太郎２",
     *      ),
     *    );
     * @return array レコード情報
     */
    abstract protected function records();
}
