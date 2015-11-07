<?php
/**
 * @buief zend2 コントローラーインターセプタ実行
 * @details 
 *  コントローラーインターセプタ実行をする。
 *  [注意]
 *     ・次以降のインターセプタを停止する場合
 *         $this->stopIntercept()
 *     ・コントローラーの実行をせず終了する場合、
 *       Responseオブジェクトを返却すると終わります。
 *       例）  return $instance->getResponse()
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Controller\Interceptor;

use Zend\EventManager\Event;
use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractInterceptor implements InterceptorInterface
{
    /**
     * @var Zend\EventManager\Event; 
     */
    private $event = null;
    
    /**
     * {@inheriteDocs}
     */
    abstract public function intercept(AbstractController $instance, ServiceLocatorInterface $locator);

    /**
     * イベント起動
     * InterceptorInitializerにて設定。
     * 
     * @param Event $e イベント
     * @return mixed 何かしら
     */
    public function onDispatch(Event $e)
    {
        $this->event = $e;
        
        $params = $e->getParams();
        return $this->intercept($params[0], $params[1]);
    }

    /**
     * イベント停止
     * @return void
     */
    protected function stopIntercept()
    {
        $this->event->stopPropagation(true);
    }
}
