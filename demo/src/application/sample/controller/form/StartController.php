<?php
/**
 * @buief Sampleフォーム 初期
 * @detail Sampleフォーム 初期
 * 
 * @since 2015/01
 * @package sample
 */
namespace Sample\Controller\Form;

use Sample\Controller\AbstractSampleActionController;
use Core\Controller\Interceptor\Marker\SessionAware;
use Core\Controller\Interceptor\Marker\HttpsOnlyAware;
use Core\Controller\Interceptor\Marker\AuthenticatedAware;
use Core\Type\PrefType;
use Core\Type\GenderType;
use Onota0318\Environment\AppEnvironment;

class StartController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware, AuthenticatedAware
{
    /**
     * 初期化
     */
    public function indexAction()
    {
        //ユースケースセッション削除
        $this->session()->remove(SampleFormStateHolder::id());
        
        //マスタのみここでセッションにセット
        $state = $this->session()->load(SampleFormStateHolder::id());
        $state->gender_list = GenderType::getList();
        $state->pref_list   = PrefType::getList();
        $this->session()->set($state);
        
        //フォーム画面へ
        $url = AppEnvironment::getInstance()->base_url . "sample/form/input";
        return $this->redirect()->toUrl($url);
    }
}
