<?php
/**
 * @buief CSRFトークン確認マーカー
 * @details CSRFトークン確認マーカー
 * コントローラーがこのマーカーを実装していた場合、
 * CSRF用のトークンの正当性を確認するインターセプタを実行する。
 * 
 * @since 2014.12
 * @package Onota0318
 */

namespace Core\Controller\Interceptor\Marker;

interface CsrfTokenVerifyAware
{
}
