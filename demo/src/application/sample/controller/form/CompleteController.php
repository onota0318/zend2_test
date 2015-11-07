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

class CompleteController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware
{
    /**
     * 
     */
    public function indexAction()
    {
        $sess = new \Zend\Session\Container("hogehoge");
        //$sm = $this->getServiceLocator()->get('Zend\Session\SessionManager');

        $sess->hoge = "hogehoge";
        
        $view = $this->getServiceLocator()->get('HtmlViewModel');
        $view->setTemplate("index/index.tpl");

        $holder = new IndexScreenHolder();
        $holder->hoge = "<b>aaaa</b>";
        $holder->datetime = DateTimer::getSystemDateTime("YmdHis");
        $view->IndexScreenHolder = $holder;

        return $view;
    }
}
