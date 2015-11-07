<?php
/**
 * Sampleモジュール基底テストケース
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Controller;

use Onota0318\Zend2Adapter\Test\AbstractHttpActionTestCase;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;

abstract class AbstractSampleControllerTest extends AbstractHttpActionTestCase
{
    /** @var array 認証定義 */
    protected $authConfig = array(
        "table"         => "member",
        "column_id"     => "login_id",
        "column_pw"     => "password",
        "column_update" => "last_login_date",
        "conditions"    => array("(deleted_date is null or deleted_date = '0000-00-00 00:00:00')"),
        "adapter"       => "adapter:default",
    );
    
    /**
     * 認証
     * 
     * @param string $id ID
     * @param string $pw PW
     * @return stdClass Identity
     */
    protected function authenticate($id, $pw)
    {
        return $this->login($this->authConfig, $id, $pw);
    }
    
    /**
     * 
     * @return type
     */
    protected function startSession()
    {
        $adapter = $this->getAdapter('adapter:default');
        $gateway = new TableGateway('session_front', $adapter);
        $handler = new DbTableGateway($gateway, new DbTableGatewayOptions());
        
        return $this->preparedSession($handler);
    }
}
