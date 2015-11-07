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

class InputController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware, AuthenticatedAware
{
    /**
     * 入力画面
     */
    public function indexAction()
    {
        //入力情報をセット
        $state  = $this->session()->load(SampleFormStateHolder::id());
        $screen = new SampleFormScreenHolder();
        $screen->loadState($state);
        $this->assignHolder($screen);
        
        //エラー情報
        $error = new \Onota0318\Holder\ErrorsScreenHolder();
        $error->errors = $state->errors;
        $this->assignHolder($error);
        
        //View
        $this->setTemplate("/form/input.tpl");
        return $this->preparedView();
    }
}
