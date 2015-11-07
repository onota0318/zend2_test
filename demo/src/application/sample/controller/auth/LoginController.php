<?php
/**
 * Sampleモジュール ログイン
 * 
 * @since 2015/01
 * @package sample
  */
namespace Sample\Controller\Auth;

use Sample\Controller\AbstractSampleActionController;
use Core\Controller\Interceptor\Marker\SessionAware;
use Core\Controller\Interceptor\Marker\HttpsOnlyAware;
use Onota0318\Holder\ErrorsStateHolder;
use Onota0318\Holder\ErrorsScreenHolder;

class LoginController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware
{
    /**
     * ログインフォーム
     */
    public function indexAction()
    {
        //エラー情報
        //なければView側でスルー
        $state  = $this->session()->load(ErrorsStateHolder::id());
        $this->session()->remove(ErrorsStateHolder::id());
        
        $screen = new ErrorsScreenHolder();
        $screen->errors = $state->errors;
        $this->assignHolder($screen);

        //View
        $this->setTemplate("/auth/login.tpl");
        return $this->preparedView();
    }
}
