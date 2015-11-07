<?php
/**
 * @buief
 * @details zend2 modelのtable生成
 * 
 * （TODO:超勝手なルール）
 * ・Daoを表すクラス：クラス名末尾は「Table」とする。
 * ・Entityを表すクラス：クラス名末尾は「Entity」とする。
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Onota0318\Constants\MasterConstants;

class TableAbstractFactory implements AbstractFactoryInterface
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
     * サービスが生成可能か判定する。
     * 
     * @param ServiceLocatorInterface $locator locator
     * @param type $name name
     * @param type $requestedName requestedName
     * @return boolean true：生成可能 false：生成不可
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        /* @buief
         * 例）引数$requestedNameが「Hoge\Huga\AhaTable」となる為、
         * 　　suffixにあたる「Table」を「Entity」に変換
         * 　　→該当しなければ、このFactoryはお呼びでない感じ
         */
        $entityName = $this->extractEntityName($requestedName);

        if (strlen($entityName) <= 0) {
            return false;
        }
        
        /* @buief
         * 「Hoge\Huga\AhaEntity」と「Hoge\Huga\AhaTable」が共に存在する場合は
         *  生成可能と判断
         */
        return class_exists($entityName)
                && class_exists($requestedName);
    }
 
    /**
     * 実体生成処理
     * 
     * @param ServiceLocatorInterface $locator locator
     * @param type $name name
     * @param type $requestedName requestedName
     * @return AbstractTable Daoの方
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        /* @buief
         * 当メソッドは「canCreateServiceWithName」の結果trueの場合に呼ばれる為、
         * Table名称等は保証済み。
         * →extractEntityNameの結果判断はしなくてモウマンタイ
         */
        $entityName = $this->extractEntityName($requestedName);
        $entity     = new $entityName($locator);
        $rs         = new ResultSet();
        $gateway    = new TableGateway($this->extractRealTableName($requestedName)
                                      ,$locator->get('Zend\Db\Adapter\Adapter')
                                      ,null
                                      ,$rs->setArrayObjectPrototype($entity));
        
        return new $requestedName($gateway);
    }
    
    /**
     * Entity名を抽出
     * @param string $requestedName サービス呼び出し時引数
     * @return string 抽出した名称
     */
    protected function extractEntityName($requestedName)
    {
        $res = preg_replace("/".self::TABLE_SUFFIX."$/", self::ENTITY_SUFFIX, $requestedName);

        //無変換→対象外
        if ($res === $requestedName) {
            return "";
        }
        
        return $res;
    }
    
    /**
     * 実テーブル名を抽出
     * 抽出条件は以下
     * １）HogeTable::TABLE_NAME
     * ２）１）がなければクラス名の「Table」を除いたもの
     * 
     * @param string $requestedName サービス呼び出し時引数
     * @return string 抽出した名称
     */
    protected function extractRealTableName($requestedName)
    {
        //１）HogeTable::TABLE_NAMEが定義済みならそこから
        if (defined($requestedName . "::TABLE_NAME")) {
            return constant($requestedName . "::TABLE_NAME");
        }
        
        //クラス名の「Table」を除いたもの
        $tmp = explode(MasterConstants::NS, $requestedName);
        return strtolower(preg_replace("/" . self::TABLE_SUFFIX . "$/", "", $tmp[count($tmp) - 1]));
    }
}
