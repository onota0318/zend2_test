<?php
/**
 * @buief オートローダー
 * @details
 *   オートローダー
 *
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Library;

use Onota0318\Constants\MasterConstants;

class Autoloader
{
    /**
     * @var boolean 適用済か？
     */
    private static $isApply = false;

    /**
     * @var array ベンダー名前空間とディレクトリのマッピング
     */
    private static $vendorNamespaceMap = array();

    /**
     * 名前空間管理登録
     *
     * @param string $vendor ベンダ名前空間名
     * @param string $directory ディレクトリ
     * @return void
     */
    public static function append($vendor, $directory)
    {
        self::$vendorNamespaceMap[$vendor] = $directory;
        self::apply();
    }

    /**
     * オートローダー適用
     *
     * @return void
     */
    private static function apply()
    {
        if (self::$isApply) {
            return;
        }

        spl_autoload_register(array(get_called_class(), "registerAutoload"));
        self::$isApply = true;
    }

    /**
     * オートローダー
     * spl_autoload_register経由で実行
     * 
     * @param string $className クラス名
     * @deprecated
     */
    public static function registerAutoload($className)
    {
        if (count(self::$vendorNamespaceMap) <= 0) {
            return;
        }

        $vendorName = StringConverter::getVendorNamespace($className);

        if (!isset(self::$vendorNamespaceMap[$vendorName])) {
            return;
        }

        $directory  = self::$vendorNamespaceMap[$vendorName];
        $namespaces = explode(MasterConstants::NS, $className);
        
        $ds   = DIRECTORY_SEPARATOR;
        $path = implode($ds, array_slice($namespaces, 1));
        $file = $directory . $ds . $path . ".php";

        clearstatcache();
        if (!is_file($file)) {
            return;
        }

        require_once $file;
    }
}
