<?php
/**
 * SampleモジュールTOP
 * 
 * @since 2015/01
 * @package sample
 */
namespace Sample\Controller;

use Core\Controller\Interceptor\Marker\HttpsOnlyAware;
use Onota0318\Environment\AppEnvironment;

class IndexController extends AbstractSampleActionController implements HttpsOnlyAware
{
    /**
     * ログインにリダイレクト
     * 
     * @return Redirect リダイレクト
     */
    public function indexAction()
    {
        $url = AppEnvironment::getInstance()->base_url . "sample/auth/login";
        return $this->redirect()->toUrl($url);
    }
}
