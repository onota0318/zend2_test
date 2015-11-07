<?php
/**
 * @buief 認証ページマーカー
 * @details 認証ページマーカー
 * コントローラーがこのマーカーを実装していた場合、
 * 認証機能インターセプタを実行する。
 * 
 * @since 2014.12
 * @package core
 */

namespace Core\Controller\Interceptor\Marker;

interface AuthenticateLoginAware extends AuthenticationInterface
{
}
