<?php
/**
 * @buief CSRFトークン生成マーカー
 * @details CSRFトークン生成マーカー
 * コントローラーがこのマーカーを実装していた場合、
 * CSRF用のトークンを発行するインターセプタを実行する。
 * 
 * @since 2014.12
 * @package Onota0318
 */

namespace Core\Controller\Interceptor\Marker;

interface CsrfTokenGenerateAware
{
}
