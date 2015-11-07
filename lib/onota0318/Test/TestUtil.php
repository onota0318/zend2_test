<?php
/**
 * @buief テストユーティリティ
 * @details テストユーティリティ
 * 
 * @since 2014
 * @package Onota0318
 */

namespace Onota0318\Test;

use Onota0318\Library\Autoloader;
use Onota0318\Library\Provider\SystemDateProvider;

class TestUtil
{
    /**
     * @var string ベンダ名前空間
     */
    const VENDOR_NAMESPACE = "Tests";

    /**
     * @var array 何かしら情報
     */
    private static $info = array();
    
    /**
     * 何かしらの情報をセットする。
     *
     * @param string $key キー
     * @param string $value 値
     * @return void
     */
    public static function setSharedInfo($key, $value)
    {
        self::$info[$key] = $value;
    }

    /**
     * 何かしらの情報を取得する。
     *
     * @param string $key キー
     * @return string 値
     */
    public static function getSharedInfo($key)
    {
        if (!isset(self::$info[$key])) {
            return "";
        }

        return self::$info[$key];
    }

    /**
     * autoload用ディレクトリを追加
     * 
     * @param string $directory ディレクトリ
     * @return void
     */
    public static function addAutoloadDirectory($directory)
    {
        Autoloader::append(self::VENDOR_NAMESPACE, $directory);
    }

    /**
     * もろもろ初期化をする。
     * @return void
     */
    public static function bootstrap()
    {
        //memory_limit無効
        ini_set("memory_limit", -1);

        //https://bugs.php.net/bug.php?id=53976
        //phpunit coverage html生成時にgcによってseg faultを引き起こすらしい・・・
        //gcを無効にする事によって解決
        ini_set("zend.enable_gc", 0);
        
        //TestCase::setUp()でも呼ぶが念のため
        self::initialize();
    }

    /**
     * testcase毎の初期化
     * @return void
     */
    public static function initialize()
    {
        //日付詐称をクリア
        self::clearSystemDateTime();
        
        //SERVER情報をクリア
        self::clearServerRequest();
    }
    
    /**
     * HTTPSの振る舞いにする
     * @return void
     */
    public static function setHttpsRequest()
    {
        self::setHttpRequest();
        $_SERVER["HTTPS"] = "on";
    }
    
    /**
     * HTTPの振る舞いにする
     * @return void
     */
    public static function setHttpRequest()
    {
        self::clearServerRequest();
        $_SERVER["HTTP_HOST"] = "TEST";
    }
    
    /**
     * Consoleの振る舞いにする
     * 
     * @return void
     */
    public static function setConsoleRequest()
    {
        self::clearServerRequest();
    }
    
    /**
     * HTTPリクエスト情報をクリア
     * @return void
     */
    private static function clearServerRequest()
    {
        if (isset($_SERVER["HTTPS"])) {
            unset($_SERVER["HTTPS"]);
        }
        
        if (isset($_SERVER["SERVER_PORT"])) {
            unset($_SERVER["SERVER_PORT"]);
        }
        
        if (isset($_SERVER["HTTP_HOST"])) {
            unset($_SERVER["HTTP_HOST"]);
        }
    }
    
    /**
     * 現在日を詐称する。
     *
     * @param string $datetime 年月日時分秒
     */
    public static function setSystemDateTime($datetime)
    {
        SystemDateProvider::setSystemDateTime(preg_replace("/[^0-9]+/", "", $datetime));
    }

    /**
     * 詐称した現在日をクリアする。
     *
     * @return void
     */
    private static function clearSystemDateTime()
    {
        SystemDateProvider::clearSystemDateTime();
    }
}
