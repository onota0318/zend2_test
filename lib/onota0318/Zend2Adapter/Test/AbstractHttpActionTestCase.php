<?php
/**
 * @buief Controllerテスト基底クラス
 * @details Controllerテスト基底クラス
 * 
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Zend2Adapter\Test;

use Zend\Http\PhpEnvironment\Response;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Onota0318\Test\TestUtil;
use Onota0318\Zend2Adapter\Controller\Plugin\AuthenticatePlugin;
use Zend\Session\SaveHandler\SaveHandlerInterface;
use Onota0318\Zend2Adapter\Controller\Plugin\SessionPlugin;

abstract class AbstractHttpActionTestCase extends AbstractHttpControllerTestCase
{
    /**
     * @var boolean traceError 
     */
    protected $traceError = true;
    
    /**
     * setUp
     * ・configの初期化
     * ・プロバイダオブジェクトの初期化
     * 
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $config = TestUtil::getSharedInfo("application.config");
        $this->setApplicationConfig(require $config);
        
        TestUtil::initialize();
        TestUtil::setHttpRequest();
    }
    
    /**
     * 
     * @param SaveHandlerInterface $handler
     * @return SessionPlugin
     */
    protected function preparedSession(SaveHandlerInterface $handler)
    {
        //ハンドラ設定
        $sess = $this->getApplicationServiceLocator()->get('Zend\Session\SessionManager');
        $sess->setSaveHandler($handler);
        
        //マネージャーをセット
        $session = new SessionPlugin();
        $session->setManager($sess);
        
        return $session;
    }
    
    /**
     * レスポンスデータを取得
     * 
     * @param string $name アサインデータ名
     * @return mixed アサインデータ
     */
    protected function getAssignedData($name)
    {
        $variables = $this->getApplicationServiceLocator()->get("HtmlViewModel")->getVariables();
        if (!isset($variables->$name)) {
            $this->fail("No Assigned ViewVariables. [$name]");
        }
        
        return $variables->$name;
    }
    
    /**
     * {@inheriteDocs}
     * @Override
     */
    public function dispatch($url, $method = null, $params = array(), $isXmlHttpRequest = false) 
    {
        parent::dispatch($url, $method, $params, $isXmlHttpRequest);
        
        if ($this->getResponseStatusCode() !== Response::STATUS_CODE_200) {
            return;
        }
//        
//        $contents = $this->getResponse()->getContent();
//        $trace = debug_backtrace();
//        $from = $trace[1]['function'];
//
//        $filename = str_replace("\\", "_", get_class($this)). "_" . $from;
////        
//        file_put_contents(dirname(__DIR__)."/". $filename . ".html", $contents);
    }
    
    /**
     * ログインする
     * @param array $config config
     * @param string $id id
     * @param string $pw pw
     * 
     * @return stdClass 認可情報
     */
    protected function login(array $config, $id, $pw)
    {
        $auth = new AuthenticatePlugin();
        
        if (isset($config["table"])) {
            $auth->setTableName($config["table"]);
        }
        
        if (isset($config["conditions"])
                && is_array($config["conditions"])) {
            $auth->setConditions($config["conditions"]);
        }
        
        if (isset($config["column_id"])) {
            $auth->setIdentityColumn($config["column_id"]);
        }
        
        if (isset($config["column_pw"])) {
            $auth->setCredentialColumn($config["column_pw"]);
        }
        
        if (isset($config["adapter"])) {
            $auth->setDbAdapter($this->getAdapter($config["adapter"]));
        }
        
        if (!$auth->login($id, $pw)) {
            $error = $auth->getErrors();
            $this->fail($error['auth']->getMessage());
        }
        
        return $auth->getIdentity();
    }
    
    /**
     * アダプタを取得
     * @param string $ident DBアダプタ識別子
     * @return Adapter アダプタ
     */
    protected function getAdapter($ident)
    {
        return $this->getApplicationServiceLocator()->get($ident);
    }
    
    /**
     * MvcEvent内での例外アサーション
     * 
     * @param string $locationName 発生個所クラス名
     * @param string $exceptionName 例外クラス名
     */
    protected function assertMvcEventException($locationName, $exceptionName)
    {
        $event = $this->getApplication()->getMvcEvent();
        $exception = $event->getParam('exception');
        
        if (!($exception instanceof \Exception)) {
            $this->fail("例外は発生していません。");
        }
        
        $location = $exception->getTrace()[0]["class"];
        $this->assertEquals($locationName,  $location);
        $this->assertEquals($exceptionName, get_class($exception));

        //PHPUnit系の例外じゃなければ
        //tearDownで例外を投げられないようにnullをセット
        if (!($exception instanceof \PHPUnit_Framework_Exception)) {
            $event->setParam('exception', null);
        }
    }
    
    /**
     * 連想配列同士のアサート
     * 
     * @param array $expected 期待値
     * @param array $actual 結果
     */
    protected function assertHashMap(array $expected, array $actual)
    {
        $expectedToJson = json_encode($expected);
        $actualToJson   = json_encode($actual);
        
        $this->assertEquals($expectedToJson, $actualToJson);
    }
    
    /**
     * Controllerのインスタンスを取得
     * 
     * @return Controller コントローラ
     */
    protected function getControllerInstance()
    {
        $routeMatch           = $this->getApplication()->getMvcEvent()->getRouteMatch();
        $controllerIdentifier = $routeMatch->getParam('controller');
        $controllerManager    = $this->getApplicationServiceLocator()->get('ControllerManager');
        $controllerClass      = $controllerManager->get($controllerIdentifier);

        return $controllerClass;
    }    
}
