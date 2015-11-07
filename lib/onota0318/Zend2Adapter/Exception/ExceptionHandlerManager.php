<?php
/**
 * @buief 例外管理
 * @details 例外管理
 * 設定元はModule.phpのonBootstrapにて
 * 
 * @package Onota0318
 * @since 2014.12
 */
namespace Onota0318\Zend2Adapter\Exception;

use Zend\Mvc\MvcEvent;
use Onota0318\Library\StringConverter;

class ExceptionHandlerManager
{
    /**
     * @var array 例外ハンドラ
     */
    private static $handlerMap = array();

    /**
     * @var ExceptionHandlerInterface 例外ハンドラ
     */
    private static $defaultHanlder = null;
    
    /**
     * 例外ハンドラを設定する
     * 
     * @param string $namespace ベンダ名前空間
     * @param ExceptionHandlerInterface $handler 例外ハンドラ
     * @return void
     */
    public static function setExceptionHandler($namespace, ExceptionHandlerInterface $handler)
    {
        self::$handlerMap[$namespace] = $handler;
    }

    /**
     * デフォルト例外ハンドラを設定する
     * 先勝ち
     * @var ExceptionHandlerInterface $handler 例外ハンドラ
     * @return void
     */
    public static function setDefaultExceptionHandler(ExceptionHandlerInterface $handler)
    {
        if (isset(self::$defaultHanlder)) {
            return;
        }
        
        self::$defaultHanlder = $handler;
    }
    
    /**
     * 例外ハンドラを実行する
     * 
     * @param MvcEvent $e MvcEvent
     * @return Response レスポンスオブジェクト
     */
    public static function handle(MvcEvent $e)
    {
        //MvcEvent停止
        $e->stopPropagation();

        $namespace = "";
        $route     = $e->getRouteMatch();
        $path      = "";
        
        if ($route !== null) {
            $path = $route->getParam("controller");
        }
        
        if (strlen($path) > 0) {
            $namespace = StringConverter::getVendorNamespace($path);
        }
        
        $handler = self::$defaultHanlder;
        if (isset(self::$handlerMap[$namespace])) {
            $handler = self::$handlerMap[$namespace];
        }
        
        if (!($handler instanceof ExceptionHandlerInterface)) {
            trigger_error("does not exists handler.", E_ERROR);
        }
        
        return $handler->handle($e);
    }
}
