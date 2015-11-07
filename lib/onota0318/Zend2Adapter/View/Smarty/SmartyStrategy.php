<?php
/**
 * @buief Smarty用のViewStrategy
 * @details Smarty用のViewStrategy
 * ZSmartyがクソ過ぎるのでソースを基に改修
 * 
 * @package Onota0318
 * @since 2014.12
 */
namespace Onota0318\Zend2Adapter\View\Smarty;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;

class SmartyStrategy implements ListenerAggregateInterface
{
    /**
     * @var string smarty用拡張子
     */
    const EXTENSION = '.tpl';
    
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var SmartyRenderer SmartyRenderer
     */
    protected $renderer;
    
    /**
     * @var array レイアウト 
     */
    protected $layouts;

    /**
     * コンストラクタ
     * 
     * @param SmartyRenderer $renderer SmartyRenderer
     * @param array $layouts レイアウト
     */
    public function __construct(SmartyRenderer $renderer, array $layouts)
    {
        $this->renderer = $renderer;
        $this->layouts  = $layouts;
    }

    /**
     * イベントリスナに追加
     *
     * @param  EventManagerInterface $events イベント
     * @param  int $priority priority
     * @return void　
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    /**
     * イベントリスナからイベント削除
     *
     * @param  EventManagerInterface $events イベント
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Rendererオブジェクトを取得
     *
     * @param  ViewEvent $e Viewイベント
     * @return SmartyRenderer 取得したRendererオブジェクト
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();
        $name  = $model->getTemplate();

        if (isset($this->layouts[$name])) {
            $name = $this->layouts[$name];
        }

        //テンプレートが「○○.tpl」ならSmarty用のレンダーを返却
        if (substr($name, strlen($name) - strlen(self::EXTENSION)) === self::EXTENSION) {
            return $this->renderer;
        }
    }

    /**
     * Inject the response with the JSON payload and appropriate Content-Type header
     *
     * @param  ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }

        $result = $e->getResult();
        if (!is_string($result)) {
            return;
        }

        // Populate response
        $response = $e->getResponse();
        $response->setContent($result);
    }
}
