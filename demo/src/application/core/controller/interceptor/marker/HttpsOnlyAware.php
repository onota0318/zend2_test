<?php
/**
 * @buief SSL専用ページマーカー
 * @details SSL専用ページマーカー
 * コントローラーがこのマーカーを実装していた場合、
 * SSLアクセスのみ許可するインターセプタを実行する。
 * 
 * @since 2014.12
 * @package Onota0318
 */

namespace Core\Controller\Interceptor\Marker;

interface HttpsOnlyAware
{
}
