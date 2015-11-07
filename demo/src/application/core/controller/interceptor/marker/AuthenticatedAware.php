<?php
/**
 * @buief 認可ページマーカー
 * @details 認可ページマーカー
 * コントローラーがこのマーカーを実装していた場合、
 * 認証済みであることを証明するインターセプタを実行する。
 * 
 * @since 2014.12
 * @package Onota0318
 */

namespace Core\Controller\Interceptor\Marker;

interface AuthenticatedAware extends AuthenticationInterface
{
}
