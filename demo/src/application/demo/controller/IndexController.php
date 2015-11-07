<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Demo\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;
use Onota0318\Exception\InputValidationException;
use Core\Controller\Interceptor\Marker\InMaintenanceAware;
use Core\Controller\Interceptor\Marker\SessionAware;
use Core\Controller\Interceptor\Marker\HttpsOnlyAware;

class IndexController extends AbstractActionController implements InMaintenanceAware, SessionAware, HttpsOnlyAware
{
//    public function preDispatch()
//    {
//        echo __METHOD__;
//    }
//    
//    public function postDispatch()
//    {
//        echo __METHOD__;
//    }
//    
    public function indexAction()
    {
        echo __METHOD__;
        
//        $session = new \Zend\Session\Container("hogehoge");
//        //$session->test = "hogehogehhoogge";
//        var_dumP($session->test);
//        var_dump($session->getManager()->getId());
//        var_dump(get_class($session));exit;
//        exit;

//        $type = \Core\Type\HogeType::AAA();
//        var_dump($type->valueOf());
//        var_dump(\Core\Type\HogeType::has("bbb"));exit;
        $logic = $this->getServiceLocator()->get('Demo\Logic\HogeLogic');

        $logic->id = "abcd";
        $logic->detail = "";

        //$this->redirect()->toRoute();
        //throw new \Exception("Hogehoge");
        try {
            $logic->validate();
            //$logic->execute();
        }
        //ERROR
        catch (InputValidationException $ive) {
            //var_dump($ive->getErrors());exit;
 //           $errors = $ive->getErrors();
 //           $this->assignView(ErrorScreenHolder::ID, $errors);

 //           return $view;
        }
            
        
        $view = $this->getServiceLocator()->get('HtmlViewModel');
        $view->setTemplate("index/index.tpl");
        $view->hoge = "<b>aaaa</b>";
        return $view;
    }
}
