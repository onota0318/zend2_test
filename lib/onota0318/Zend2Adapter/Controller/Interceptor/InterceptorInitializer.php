<?php
/**
 * @buief zend2 コントローラーインターセプタ実行
 * @details 
 *  コントローラーインターセプタ実行をする。
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Controller\Interceptor;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\Event;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\Stdlib\ResponseInterface as Response;
use Onota0318\Constants\MasterConstants;

class InterceptorInitializer implements InitializerInterface
{
    /**
     * @var string イベント名
     */
    const EVENT_INTERCEPT = "intercept";
    
    /**
     * @var EventManager event 
     */
    private $events = null;
    
    /**
     * コントローラーの初期化処理
     * マーカインターフェースにしたがって初期化をする。
     * module.config.phpのcontrollersセクションで定義
     * 
     * @param AbstractController $instance コントローラー
     * @param ServiceLocatorInterface $serviceLocator 実際の中身はControllerManager
     * @return void
     * 
     * @throws \BadMethodCallException
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $config = $sm->get("Config");

        //定義なし
        if (!isset($config['controllers']['interceptor'])) {
            throw new \BadMethodCallException(
                  "intercept定義が存在しません。"
                . "コントローラー：[" . get_class($instance) . "]"
            );
        }

        $conf = array();
        $interceptor = $config['controllers']['interceptor'];

        //Webアプリの場合
        if ($instance instanceof AbstractActionController) {
            if (!isset($interceptor['action'])) {
                return;
            }
            
            $conf = $interceptor['action'];
        }
        //Consoleアプリの場合
        elseif ($instance instanceof AbstractConsoleController) {
            if (!isset($interceptor['console'])) {
                return;
            }

            $conf = $interceptor['console'];
        }
        //上記以外→例外
        else {
            throw new \BadMethodCallException(
                  "intercept定義が正しくありません。"
                . "コントローラー：[" . get_class($instance) . "]"
            );
        }
        
        //イベントマネージャーの登録
        $this->setEventManager($sm->get("EventManager"));
        
        //イベント登録
        $this->attachEvents($instance, $serviceLocator, $conf);
    } 

    /**
     * インターセプタ独自のイベントマネージャーを登録
     * 
     * @param EventManagerInterface $events イベントマネージャー
     * @return void
     */
    protected function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            "Onota0318\Zend2Adapter\Controller\Interceptor\InterceptorInterface",
            __CLASS__,
            get_called_class(),
            self::EVENT_INTERCEPT,
            substr(get_called_class(), 0, strpos(get_called_class(), MasterConstants::NS))
        ));
        
        $this->events = $events;
    }

    /**
     * イベント登録
     * 
     * @param AbstractController $instance コントローラー
     * @param ServiceLocatorInterface $locator locator
     * @param array $conf 設定
     */
    protected function attachEvents(AbstractController $instance, ServiceLocatorInterface $locator, array $conf)
    {
        $em = $this->events;

        $event = new Event();
        $event->setName(self::EVENT_INTERCEPT);
        $event->setParams(array($instance, $locator));
            
        $isAttached = false;
        $priorityCounter = 100;
        
        foreach ($conf as $marker => $intercept) {
            //マーカーInterface未実装→終了
            if (!($instance instanceof $marker)) {
                continue;
            }
            
            --$priorityCounter;
            
            //Closureでの定義
            if ($intercept instanceof \Closure) {
                $em->attach(self::EVENT_INTERCEPT, function ($e) use ($intercept) {
                    $params = $e->getParams();
                    return $intercept($e, $params[0], $params[1]);
                }, $priorityCounter);
                
                $isAttached = true;
                continue;
            }
            
            //クラス定義
            if (class_exists($intercept)
                    && is_subclass_of($intercept, __NAMESPACE__ . "\AbstractInterceptor")) {
                $em->attach(self::EVENT_INTERCEPT, array(new $intercept(), 'onDispatch'), $priorityCounter);
                $isAttached = true;
                continue;
            }
        }
        
        /* @buief
         * 1回以上イベント登録された場合、
         * Controllerのdispatchイベントをトリガとする。
         * 　⇒dispatchイベントの最上位プライオリティとして登録し、
         * 　　dispatchイベントの起動時に最初にインターセプタが実行されるようにする。
         */
        if ($isAttached) {
            $instance->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, function($e) use ($em, $event) {
                $res = $em->trigger(self::EVENT_INTERCEPT, $event);

                if ($res->stopped()) {
                    return $res->last();
                }
            }, 99999);
        }
    }
}
