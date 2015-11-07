<?php
/**
 * @buief システム日付提供
 * @details
 *   システム日付提供
 *   OSのアーキテクチャは64bit前提としている為、2038年問題は考慮しない
 *
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Library\Provider;

final class SystemDateProvider
{
    /**
     * @var string 年月日時分秒
     */
    private static $ymdhis = "";

    /**
     * セットされた日付を削除する
     * @return void
     */
    public static function clearSystemDateTime()
    {
        self::$ymdhis = "";
    }
    
    /**
     * 年月日時分秒を設定
     * （システムテストの詐称系とかで）
     * 
     * @param string $ymdhis 現在時分秒
     */
    public static function setSystemDateTime($ymdhis)
    {
        if (strlen($ymdhis) !== 14) {
            return;
        }

        self::$ymdhis = $ymdhis;
    }

    /**
     * 年月日時分秒を取得
     * （システムテストの詐称系とかで）
     *
     * @return string 年月日時分秒
     */
    public static function getSystemDateTime($format = "YmdHis")
    {
        return date($format, self::getSystemTimestamp());
    }

    /**
     * タイムスタンプを取得
     *
     * @return number タイムスタンプ
     */
    public static function getSystemTimestamp()
    {
        $ymdhis = self::$ymdhis;

        if (strlen($ymdhis) <= 0) {
            $ymdhis = date("YmdHis");
        }

        return strtotime($ymdhis);
    }
}