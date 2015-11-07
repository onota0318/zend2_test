<?php
/**
 * @buief 認証用プラグイン
 * @details 認証用プラグイン
 *
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Controller\Plugin;

use Zend\Db\Adapter\Adapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\Adapter\DbTable\Exception;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Onota0318\Library\StringConverter;
use Onota0318\Message\Message;

class AuthenticatePlugin extends AbstractPlugin
{
    /** @var string エラーメッセージのキー */
    const FAILURE_MESSAGE_KEY = "auth";
    
    /** @var AuthenticationService */
    private $auth = null;
    
    /** @var Adapter アダプタ */
    private $adapter = null;
    
    /** @var string テーブル名 */
    private $table = "";

    /** @var string IDカラム名 */
    private $columnId = "";
    
    /** @var string PWカラム名 */
    private $columnPw = "";

    /** @var array 条件 */
    private $conditions = array();

    /** @var array エラー */
    private $errors = array();
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->auth = new AuthenticationService(new SessionStorage());
    }
    
    /**
     * DBアダプタをセットする
     * 
     * @param Adapter $adapter
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    /**
     * 認証テーブル名をセットする
     * 
     * @param string $table テーブル名
     */
    public function setTableName($table)
    {
        $this->table = $table;
    }
    
    /**
     * 認証IDカラム名をセットする
     * 
     * @param string $column IDカラム
     */
    public function setIdentityColumn($column)
    {
        $this->columnId = $column;
    }

    /**
     * 認証PWカラム名をセットする
     * 
     * @param string $column カラム名
     */
    public function setCredentialColumn($column)
    {
        $this->columnPw = $column;
    }
    
    /**
     * 検索条件をセットする
     * 
     * @param array $conditions 条件
     */
    public function setConditions(array $conditions = array())
    {
        $this->conditions = $conditions;
    }
    
    /**
     * 認証する
     * 
     * @param string $id ID
     * @param string $pw パスワード
     * @param boolean $isConvertHash ハッシュ化するか？
     * @return boolean
     */
    public function login($id, $pw, $isConvertHash = true)
    {
        $this->logout();
        
        $authAdapter = new AuthAdapter($this->adapter);
        
        $authAdapter->setTableName($this->table);
        $authAdapter->setIdentityColumn($this->columnId);
        $authAdapter->setCredentialColumn($this->columnPw);
        
        $authAdapter->setIdentity($id);
        
        if ($isConvertHash) {
            $pw = StringConverter::hash($pw);
        }
        
        $authAdapter->setCredential($pw);
        
        if (count($this->conditions) > 0) {
            $select = $authAdapter->getDbSelect();
            $select->where($this->conditions);
        }

        try {
            $result = $this->auth->authenticate($authAdapter);
        } catch (Exception\RuntimeException $re) {
            $this->errors = array($re->getMessage());
            return false;
        }
        
        if (!$result->isValid()) {
            $this->errors = $result->getMessages();
            return false;
        }
        
        $this->auth->getStorage()->write($authAdapter->getResultRowObject());
        return true;
    }
    
    /**
     * エラー情報を返す
     * 
     * @return array エラー情報
     */
    public function getErrors()
    {
        $error = $this->errors[0];
      
        $message = new Message();
        $message->setMessage($error);
        
        return array(
            self::FAILURE_MESSAGE_KEY => $message,
        );
    }
    
    /**
     * ログアウト
     */
    public function logout()
    {
        $this->auth->clearIdentity();
    }
    
    /**
     * ログインユーザー情報を取得
     * 
     * @return stdClass 認可情報
     */
    public function getIdentity()
    {
        return $this->auth->getIdentity();
    }
    
    /**
     * ログイン中か確認
     * 
     * @return boolean
     */
    public function isLogin()
    {
        return $this->auth->hasIdentity();
    }
}
