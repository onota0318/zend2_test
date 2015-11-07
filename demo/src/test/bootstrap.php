<?php
/**
 * test用bootstrap
 */
use Onota0318\Test\TestUtil;
use Onota0318\Environment\AppEnvironment as ENV;

//zf2のセッションID
define('SID', 'TEST_SESSID');

//autoloaderをインクルード
require_once 'autoload.php';

//プロジェクトルートに移動
//(config内相対パス解釈の為)
$appRoot = dirname(dirname(__DIR__));
chdir($appRoot);

//環境設定
putenv("APPLICATION_ENV=" . ENV::ENV_DEVELOPMENT);
$_ENV[ENV::IDENT_UNITTEST_ENV_KEY] = ENV::IDENT_UNITTEST_ENV_VALUE;

//テスト用オートローダー
TestUtil::addAutoloadDirectory(dirname(__FILE__));

//何かしらの情報
TestUtil::setSharedInfo("application.root"  , $appRoot);
TestUtil::setSharedInfo("application.config", $appRoot . "/config/application.config.php");

//init
TestUtil::bootstrap();
