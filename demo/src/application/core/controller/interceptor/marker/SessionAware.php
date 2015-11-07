<?php
/**
 * @buief セッション生成マーカー
 * @details セッション生成マーカー
 * コントローラーがこのマーカーを実装していた場合、
 * セッション生成インターセプタを実行する。
 * 
 * @since 2014.12
 * @package core
 */
namespace Core\Controller\Interceptor\Marker;

interface SessionAware
{
    /**
     * セッションセーブハンドラ定義をする。
     * 
     * @return Zend\Session\SaveHandler\SaveHandlerInterface ハンドラ
     */
    public function getSessionSaveHandler();    
}
