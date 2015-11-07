<?php
/**
 * Sampleモジュール　ログイン認証処理
 * 
 * @since 2015/01
 * @package sample
  */
namespace Sample\Controller\Auth;

use Sample\Controller\AbstractSampleActionController;
use Core\Controller\Interceptor\Marker\SessionAware;
use Core\Controller\Interceptor\Marker\HttpsOnlyAware;
use Core\Controller\Interceptor\Marker\AuthenticateLoginAware;
use Onota0318\Environment\AppEnvironment;
use Onota0318\Holder\ErrorsStateHolder;

class AuthenticateController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware, AuthenticateLoginAware
{
    /**
     * 認証処理
     */
    public function indexAction()
    {
        //エラー情報をセッションから削除
        $this->session()->remove(ErrorsStateHolder::id());
        
        //入力値（POST）から受け取る
        $id = $this->getPost('login_id');
        $pw = $this->getPost('login_pw');
        
        //ログイン
        if (!$this->authenticate()->login($id, $pw)) {
            //失敗の場合、エラーをセッションに詰めてログイン画面へ
            //TODO メッセージ外だし
            $message = "認証情報が確認できませんでした。";
            //$errors = $this->authenticate()->getErrors();
            $errors = array(
                'auth' => (new \Onota0318\Message\Message())->setMessage($message),
            );
            
            $state = $this->session()->load(ErrorsStateHolder::id());
            $state->errors = $errors;
            $this->session()->set($state);
            
            $url = AppEnvironment::getInstance()->base_url . "sample/auth/login";
            return $this->redirect()->toUrl($url);
        }
        
        //セッションID更新
        $this->session()->regenerateId();
        
        //フォームへ
        $url = AppEnvironment::getInstance()->base_url . "sample/form/start";
        return $this->redirect()->toUrl($url);
    }
}
