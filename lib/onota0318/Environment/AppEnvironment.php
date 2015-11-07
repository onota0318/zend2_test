<?php
/**
 * @buief 環境にまつわるetc..
 * @details 環境にまつわるetc..
 * 
 * @since 2014
 * @package Onota0318
 */

namespace Onota0318\Environment;

use Onota0318\Library\StringConverter;

final class AppEnvironment
{
    /**
     * @var string 環境変数：開発環境
     */
    const ENV_DEVELOPMENT = "development";

    /**
     * @var string 環境変数：検証環境
     */
    const ENV_STAGING     = "staging";

    /**
     * @var string 環境変数：本番環境
     */
    const ENV_PRODUCTION  = "production";
    
    /** @var string ユニットテスト識別子（キー） */
    const IDENT_UNITTEST_ENV_KEY = "APPLICATION_UNITTEST";

    /** @var string ユニットテスト識別子（値） */
    const IDENT_UNITTEST_ENV_VALUE = "UNITTEST";
    
    /**
     * @var string 環境（デフォルト本番） 
     */
    private static $env = "";

    /**
     * @var string 環境ファイル 
     */
    private static $file = "";
    
    /**
     * @var ApplicationEnv インスタンス 
     */
    private static $instance = null;
    
    /**
     * @var array Config 
     */
    private $config = array();
    
    /**
     * 環境変数をセットする。
     * 
     * @param string $env 環境変数
     * @return void
     */
    public static function setEnv($env = self::ENV_PRODUCTION)
    {
        //1回セットされたらおしまい
        if (strlen(self::$env) > 0) {
            return;
        }
        
        switch ($env) {
            case self::ENV_DEVELOPMENT:
            case self::ENV_STAGING:
            case self::ENV_PRODUCTION:
                break;
            
            default:
                $env = self::ENV_PRODUCTION;
        }
        
        self::$env = $env;
    }
    
    /**
     * 環境識別子を取得
     * 
     * @return string ENV
     */
    public static function getEnv()
    {
        return self::$env;
    }
    
    /**
     * configファイルをセットする。
     * 
     * @param string $file ファイル（フルパス）
     * @return void
     */
    public static function setConfigFile($file)
    {
        self::$file = $file;
    }

    /**
     * インスタンスを取得する。（シングルトン）
     * 
     * @return AppEnvironment このインスタンス
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * シングルトンインスタンスを削除
     * 
     * @return void
     */
    public static function clearInstance()
    {
        self::$instance = null;
    }
    
    /**
     * コンストラクタ
     * シングルトン設計の為、外からは呼べないようにprivateにしている。
     *
     * @throws \InvalidArgumentException
     */
    private function __construct()
    {
        clearstatcache();
        $file = realpath(str_replace("..", "", self::$file));
        
        if (!is_file($file)
                || !is_readable($file)) {
            throw new \InvalidArgumentException(
                 "設定ファイルが読み込めません。"
                ."ファイル[" . $file . "]"
                ."環境[" . $file . "]"
            );
        }
        
        $list = parse_ini_file($file);
        if (false === $list) {
            throw new \InvalidArgumentException(
                 "設定ファイルが読み込めません。"
                ."ファイル[" . $file . "]"
                ."環境[" . $file . "]"
            );
        }
        
        $this->config = $list;
    }

    /**
     * 設定ファイルデータ取得
     * 
     * @param string $key 項目名
     * @return string 項目
     * 
     * @throws \InvalidArgumentException
     */
    public function __get($key)
    {
        if (!isset($this->config[$key])) {
            throw new \InvalidArgumentException(
                 "設定ファイルに定義されていない項目です。"
                ."ファイル[" . self::$file . "]"
                ."項目名[" . $key . "]"
            );
        }
        
        return $this->config[$key];
    }
    
    /**
     * 開発環境か？
     * 
     * @return boolean true:開発 false:開発じゃない
     */
    public function isDevelopment()
    {
        return $this->is(self::ENV_DEVELOPMENT);
    }

    /**
     * 検証環境か確認
     * 
     * @return boolean true:検証 false:検証じゃない
     */
    public function isStaging()
    {
        return $this->is(self::ENV_STAGING);
    }
    
    /**
     * 本番環境か確認
     * 
     * @return boolean true:本番 false:本番じゃない
     */
    public function isProduction()
    {
        return $this->is(self::ENV_PRODUCTION);
    }
    
    /**
     * 稼働環境の確認
     * 
     * @param string $env 環境変数
     * @return boolean true:稼働環境 false:稼働環境ではない
     */
    public function is($env)
    {
        return $env === self::$env;
    }
    
    /**
     * UnitTest中か？
     * (プロダクトでは極力使用しない)
     * 
     * @return boolean
     * @deprecated
     */
    public function isUnitTest()
    {
        return $this->isDevelopment()
            && self::IDENT_UNITTEST_ENV_VALUE 
                === $this->getEnvGlobal(self::IDENT_UNITTEST_ENV_KEY);
    }
    
    /**
     * HTTPS(SSL)か判定
     * 
     * @return true:HTTPS(SSL) false:HTTP
     */
    public function isHttps()
    {
        //TODO:以下条件だけでは不足？（分散環境だと443で来ない可能性もあり）
        return $this->getServerGlobal("HTTPS") === "on"
            || $this->getServerGlobal("SERVER_PORT") === "443";
    }

    /**
     * コンソールアプリか判定
     * 
     * @return boolean true:Console false:Consoleではない
     */
    public function isConsole()
    {
        //PHP_SAPI === "cli"だとユニットテストがNG
        return strlen($this->getServerGlobal("HTTP_HOST")) <= 0;
    }
    
    /**
     * $_SERVERの情報を取得
     * 
     * @param string $key キー
     * @return string 取得データ
     */
    public function getServerGlobal($key)
    {
        if (!isset($_SERVER[$key])) {
            return "";
        }
        
        //PHPのfilter_inputは信用できないので、、、
        //独自エスケープにする。
        return StringConverter::removeUnsafeCharacter($_SERVER[$key]);
    }
    
    /**
     * $_ENVの情報を取得
     * 
     * @param string $key キー
     * @return string 取得データ
     */
    public function getEnvGlobal($key)
    {
        if (!isset($_ENV[$key])) {
            return "";
        }
        
        //PHPのfilter_inputは信用できないので、、、
        //独自エスケープにする。
        return StringConverter::removeUnsafeCharacter($_ENV[$key]);
    }
}
