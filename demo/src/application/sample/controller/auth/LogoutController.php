<?php
/**
 * Sampleモジュール ログアウト
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

class LogoutController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware, AuthenticateLoginAware
{
    /**
     * ログインフォーム
     */
    public function indexAction()
    {
        if ($this->authenticate()->isLogin()) {
            //ログアウト
            $this->authenticate()->logout();

            //セッション破棄
            $this->session()->destroy();
        }
        
        //ログイン
        $url = AppEnvironment::getInstance()->base_url . "sample/auth/login";
        return $this->redirect()->toUrl($url);        
    }
}
