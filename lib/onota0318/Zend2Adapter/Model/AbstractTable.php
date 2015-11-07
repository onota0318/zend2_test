<?php
/**
 * @buief Table基底
 * @details Table基底クラス
 * 
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Zend2Adapter\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\ResultSet\ResultSet;
use Onota0318\Constants\MasterConstants;

abstract class AbstractTable implements AdapterAwareInterface
{
    /**
     * @var string テーブルSUFFIX
     */
    const TABLE_SUFFIX = "Table";

    /**
     * @var string エンティティSUFFIX
     */
    const ENTITY_SUFFIX = "Entity";
    
    /**
     * @var Adapter アダプタ 
     */
    protected $adapter = null;
    
    /**
     * @var TableGateway TableGateway 
     */
    protected $tableGateway;

    /**
     * {@inheriteDocs}
     */
    public function setDbAdapter(Adapter $adapter) 
    {
        $this->adapter = $adapter;
    }
    
    /**
     * 初期化
     * 
     * @return AbstractTable Tableオブジェクト
     */
    public function initialize()
    {
        $entityName = $this->extractEntityName();
        $entity     = new $entityName($this->adapter);
        
        $gateway = new TableGateway($this->extractRealTableName()
                                   ,$this->adapter
                                   ,null
                                   ,(new ResultSet())->setArrayObjectPrototype($entity));

        $this->tableGateway = $gateway;
        return $this;
    }
   
    /**
     * TableGatewayのバイパス
     * 
     * @param string $method メソッド名
     * @param array $args 引数
     * 
     * @return mixed callしたメソッドの戻り
     * @throws Exception
     */
    public function __call($method, array $args = array())
    {
        if (!method_exists($this->tableGateway, $method)) {
            return;
        }
        
        return call_user_func_array(array($this->tableGateway, $method), $args);
    }

    /**
     * 空のEntityオブジェクトを返却
     * 
     * @return AbstractEntity エンティティ
     */
    public function loadNewEntity()
    {
        return clone $this->tableGateway->getResultSetPrototype()->getArrayObjectPrototype();
    }
    
    /**
     * 全件取得
     * 
     * @return ResultSet 結果オブジェクト
     */
    public function findAll()
    {
        return $this->tableGateway->select()->buffer();
    }
    
    /**
     * PKでselectする
     * 
     * @param string $primaryName PK物理名
     * @param mixed $id ID
     * @return AbstractEntity エンティティ
     */
    public function findById($primaryName, $id)
    {
        $res = $this->tableGateway->select(array($primaryName => $id));
        return $res->current();
    }
    
    /**
     * Entity名を抽出
     * @return string 抽出した名称
     */
    private function extractEntityName()
    {
        $name = get_class($this);
        $res  = preg_replace("/".self::TABLE_SUFFIX."$/", self::ENTITY_SUFFIX, $name);

        //無変換→対象外
        if ($res === $name) {
            //TODO:exception
        }
        
        return $res;
    }    
    
    /**
     * 実テーブル名を抽出
     * 抽出条件は以下
     * １）HogeTable::TABLE_NAME
     * ２）１）がなければクラス名の「Table」を除いたもの
     * 
     * @return string 抽出した名称
     */
    private function extractRealTableName()
    {
        //１）HogeTable::TABLE_NAMEが定義済みならそこから
        if (defined("static::TABLE_NAME")) {
            return constant("static::TABLE_NAME");
        }
        
        //クラス名の「Table」を除いたもの
        $tmp = explode(MasterConstants::NS, get_class($this));
        return strtolower(preg_replace("/" . self::TABLE_SUFFIX . "$/", "", $tmp[count($tmp) - 1]));        
    }
}
