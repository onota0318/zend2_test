<?php
/**
 * @buief ビジネスロジック（Service層）の基底
 * @details 
 *   LogicDelegatorによってインスタンス生成や実行が行われる
 *
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Logic;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;

abstract class AbstractDomainLogic extends AbstractLogic implements AdapterAwareInterface
{
    /**
     * @var string 使用するアダプタ名（database.config.phpのキー名）
     */
    public $useAdapter = "default";
    
    /**
     * @var Adapter アダプタ 
     */
    private $adapter = null;

    /**
     * {@inheriteDocs}
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    /**
     * テーブルオブジェクトを取得
     * 
     * @param string $fullname テーブルクラスフルパス
     * @return AbstractTable テーブルオブジェクト
     */
    protected function getTable($fullname)
    {
        if (!($this->adapter instanceof Adapter)) {
            throw new \RuntimeException(
                 "アダプタが存在しません！"
                ."ロジック名[". get_class($this) ."]"
            );
        }
        
        $table = new $fullname();
        $table->setDbAdapter($this->adapter);
        
        return $table->initialize();
    }
    
    /**
     * コネクションリソースを取得
     * トランザクション例）
     *   $this->getConnection()->beginTransaction();
     *   $this->getConnection()->commit();
     *   $this->getConnection()->rollback()
     * 
     * @return Connection コネクション
     * @see Zend\Db\Adapter\Driver\ConnectionInterface
     */
    protected function getConnection()
    {
        if (!($this->adapter instanceof Adapter)) {
            throw new \RuntimeException(
                 "アダプタが存在しません！"
                ."ロジック名[". get_class($this) ."]"
            );
        }
        
        return $this->adapter->getDriver()->getConnection();
    }
}
