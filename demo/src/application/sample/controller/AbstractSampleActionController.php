<?php
/**
 * Sampleモジュールの基底HttpController
 * @codeCoverageIgnore
 */
namespace Sample\Controller;

use Zend\Db\TableGateway\TableGateway;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Mvc\Controller\AbstractActionController;
use Onota0318\Library\StringConverter;
use Onota0318\Holder\AbstractScreenHolder;
use Core\Controller\Interceptor\Marker;

abstract class AbstractSampleActionController extends AbstractActionController
{
    /**
     * @var ViewModel ビュー 
     */
    private $view = null;

    /**
     * セッションセーブハンドラ定義をする。
     * 
     * @return Zend\Session\SaveHandler\SaveHandlerInterface ハンドラ
     * @link \Core\Controller\Interceptor\Marker\SessionAware
     */
    public function getSessionSaveHandler()
    {
        $adapter = $this->serviceLocator->get('adapter:default');
        $gateway = new TableGateway('session_front', $adapter);
        return new DbTableGateway($gateway, new DbTableGatewayOptions());
    }
    
    /**
     * 認証定義をする。
     * 戻り値の配列には必ず以下の要素が含まれている事
     * 
     * [table] => 認証テーブル名
     * [column_id] => IDカラム名
     * [column_pw] => PWカラム名
     * [conditions] => array(検索条件)
     * [adapter]  => DBアダプタ名
     * 
     * @return array 認証情報
     * @link \Core\Controller\Interceptor\Marker\AuthenticationInterface
     */
    public function getAuthenticateConfig()
    {
        return array(
            "table"         => "member",
            "column_id"     => "login_id",
            "column_pw"     => "password",
            "column_update" => "last_login_date",
            "conditions"    => array("(deleted_date is null or deleted_date = '0000-00-00 00:00:00')"),
            "adapter"       => "adapter:default",
        );
    }
    
    /**
     * POSTデータを取得
     * 
     * @param string $param パラメータ名
     * @return string 安全に変換した文字列
     */
    protected function getPost($param)
    {
        $data = $this->getRequest()->getPost($param);
        
        if (is_array($data)) {
            foreach ($data as $field => $value) {
                $data[$field] = $this->convertSafetyRequestCharacter($value);
            }
        } 
        else {
            $data = $this->convertSafetyRequestCharacter($data);
        }
        
        return $data;
    }
    
    /**
     * GETを取得
     * 
     * @param string $param パラメータ名
     * @return string 安全に変換した文字列
     */
    protected function getQuery($param)
    {
        $data = $this->getRequest()->getQuery($param);
        return $this->convertSafetyRequestCharacter($data);
    }
    
    /**
     * リクエスト文字列を安全に変換する
     * 
     * @param strine $data 変換対象データ
     * @return string 変換後データ
     */
    protected function convertSafetyRequestCharacter($data)
    {
        if (strlen($data) <= 0) {
            return "";
        }
        
        return StringConverter::removeUnsafeCharacter($data);
    }

    /**
     * Logicをロードする。
     * 
     * @param string $logicName Logicクラス名
     * @return \Onota0318\Zend2Adapter\Logic\LogicDelegator ロジック
     * @throws \LogicException
     */
    protected function loadLogic($logicName)
    {
        $logic = $this->serviceLocator->get($logicName);
        if (!($logic instanceof \Onota0318\Zend2Adapter\Logic\LogicDelegator)) {
            throw new \LogicException(
                 "Logicクラスのロードに失敗しました。"
                ."Logic[". $logicName ."]"
            );
        }
        
        return $logic;
    }
    
    /**
     * 表示データをセットする
     * 
     * @param AbstractScreenHolder $holder ホルダ
     * @return self 自オブジェクト
     */
    protected function assignHolder(AbstractScreenHolder $holder)
    {
        $this->factoryViewModel();

        //ココからホルダへのセット禁止
        $holder->disablePropertySet();
        
        $id = $holder::id();
        $this->view->$id = $holder;
        return $this;
    }

    /**
     * テンプレートパスをセットする
     * 
     * @param string $template テンプレートパス
     * @return self 自オブジェクト
     */
    protected function setTemplate($template)
    {
        $this->factoryViewModel();
        
        $this->view->setTemplate($template);
        return $this;
    }
    
    /**
     * ViewModelを準備し返却
     * 
     * @return ViewModel ビューモデル
     */
    protected function preparedView()
    {
        $this->factoryViewModel();
        
        $path = $this->getModuleRootPath() . "/view/layout/";

        $holder = new GlobalScreenHolder();
        $holder->header = $path . "header.tpl";
        $holder->footer = $path . "footer.tpl";
        
        //認証系なら
        if ($this instanceof Marker\AuthenticatedAware) {
            $holder->identity = $this->authenticate()->getIdentity();
            $holder->isLogin  = $this->authenticate()->isLogin();
        }
        
        $this->assignHolder($holder);
        return $this->view;
    }

    /**
     * ViewModelを生成する
     * 
     * @return void
     */
    private function factoryViewModel()
    {
        if ($this->view === null) {
            $this->view = $this->getServiceLocator()->get('HtmlViewModel'); 
        }
    }
    
    /**
     * ルートパスを取得
     * 
     * @return string ルートパス
     */
    protected function getModuleRootPath()
    {
        $module = StringConverter::getVendorNamespace(get_class($this));
        return $this->serviceLocator->get("ModuleManager")->getModule($module)->getRootPath();
    }
}
