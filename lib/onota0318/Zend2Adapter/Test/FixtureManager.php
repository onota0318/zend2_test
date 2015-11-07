<?php
/**
 * @buief Fixture担当
 * @details Fixture担当
 * 
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Zend2Adapter\Test;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

final class FixtureManager
{
    /**
     * @var Adapter アダプタ 
     */
    private static $adapter = null;
    
    /**
     * アダプタをセットする。
     * 
     * @param Adapter $adapter アダプタ
     * @return void
     */
    public static function setAdapter(Adapter $adapter)
    {
        self::$adapter = $adapter;
    }

    /**
     * アダプタを取得
     * 
     * @return Adapter アダプタ
     * @throws \RuntimeException
     */
    protected static function getAdapter()
    {
        if (!(self::$adapter instanceof Adapter)) {
            throw new \RuntimeException(
                "アダプタが存在しません！"
            );
        }
        
        return self::$adapter;
    }

    /**
     * レコードを入れなおす
     * 
     * @param AbstractFixtureRecord $record レコードオブジェクト
     * @return void
     */
    public static function load(AbstractFixtureRecord $record)
    {
        self::truncate($record);
        self::insert($record);
    }
    
    /**
     * truncateする
     * 
     * @param AbstractFixtureRecord $record レコードオブジェクト
     * @return void
     */
    public static function truncate(AbstractFixtureRecord $record)
    {
        $adapter = self::getAdapter();
        $table   = $adapter->getPlatform()->quoteIdentifier($record->getTableName());
        $adapter->query("truncate table " . $table, Adapter::QUERY_MODE_EXECUTE);
    }
    
    /**
     * insertする
     * 
     * @param AbstractFixtureRecord $record レコードオブジェクト
     * @return void
     * 
     * @throws \Exception
     */
    public static function insert(AbstractFixtureRecord $record)
    {
        $adapter = self::getAdapter();
        $sql     = new Sql($adapter);
        $insert  = $sql->insert();
        $insert->into($record->getTableName());
        $insert->columns($record->getFields());
        
        $connecter = $adapter->getDriver()->getConnection();
        $connecter->beginTransaction();
        
        try {
            foreach ($record->getRecords() as $row) {
                $insert->values($row);
                $adapter->query($sql->getSqlStringForSqlObject($insert), Adapter::QUERY_MODE_EXECUTE);
            }
        } 
        //ロールバック
        catch(\Exception $e) {
            $connecter->rollback();
            throw $e;
        }
        
        $connecter->commit();
    }
}
