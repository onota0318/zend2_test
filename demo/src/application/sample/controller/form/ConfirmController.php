<?php
/**
 * SampleモジュールTOP
 * 
 * @since 2015/01
 * @package sample
 */
namespace Sample\Controller\Form;

use Sample\Controller\AbstractSampleActionController;
use Core\Controller\Interceptor\Marker\SessionAware;
use Core\Controller\Interceptor\Marker\HttpsOnlyAware;
use Core\Controller\Interceptor\Marker\AuthenticatedAware;
use Onota0318\Exception\InputValidationException;
use Onota0318\Environment\AppEnvironment;

class ConfirmController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware, AuthenticatedAware
{
    /**
     * 確認画面
     */
    public function indexAction()
    {
        //入力値をセッションにセット
        $state = $this->session()->load(SampleFormStateHolder::id());
        $state->first_name = $this->getPost("first_name");
        $state->last_name  = $this->getPost("last_name");
        $state->gender     = $this->getPost("gender");
        $state->pref       = $this->getPost("pref");
        $state->errors     = null;
        $this->session()->set($state);

        //ビジネスロジック
        $logic = $this->loadLogic("\Sample\Logic\SampleFormLogic");
        $logic->first_name = $state->first_name;
        $logic->last_name  = $state->last_name;
        $logic->gender     = $state->gender;
        $logic->pref       = $state->pref;
        
        //エラーチェック
        try {
            $logic->validate();
        } 
        //バリデーションエラーのみ
        catch (InputValidationException $ve) {
            $state->errors = $ve->getErrors();
            $this->session()->set($state);
            
            //フォーム画面へ
            $url = AppEnvironment::getInstance()->base_url . "sample/form/input";
            return $this->redirect()->toUrl($url);
        }

        //View準備
        $screen = new SampleFormScreenHolder();
        $screen->loadState($state);
        $this->assignHolder($screen);

        $this->setTemplate("/form/confirm.tpl");
        return $this->preparedView();
    }
}
