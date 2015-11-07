<?php
/**
 * @buief 認証インターフェース
 * @details 認証インターフェース
 * AuthenticateLoginAwareとAuthenticatedAwareの基底
 * 
 * @since 2014.12
 * @package core
 */

namespace Core\Controller\Interceptor\Marker;

interface AuthenticationInterface
{
    /**
     * 認証定義をする。
     * 戻り値の配列には必ず以下の要素が含まれている事
     * 
     * [table] => 認証テーブル名
     * [column_id] => IDカラム名
     * [column_pw] => PWカラム名
     * [conditions] => array(検索条件)
     * [adapter]  => DBアダプタ名
     * 
     * @return array 認証情報
     */
    public function getAuthenticateConfig();
}
