<?php
/**
 * Sampleモジュール共通スクリーンホルダ
 * 
 * @since 2015/01
 * @package sample
 */
namespace Sample\Controller;

use Onota0318\Holder\AbstractScreenHolder;

class GlobalScreenHolder extends AbstractScreenHolder
{
    /** @var string ヘッダファイル */
    protected $header = "";

    /** @var string フッタファイル */
    protected $footer = "";
    
    /** @var boolean ログイン中か？ */
    protected $isLogin = false;
    
    /** @var stdClass ログイン者情報 */
    protected $identity = null;
}
