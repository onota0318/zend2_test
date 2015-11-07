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

class RegisterController extends AbstractSampleActionController implements SessionAware, HttpsOnlyAware
{
    /**
     * 
     */
    public function indexAction()
    {
    }
}
