<?php
/**
 * @buief UserAgent判定
 * @details
 *   UserAgent判定
 *
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Library;

use Onota0318\Environment\AppEnvironment;

class UserAgentNavigator
{
    public static function isSmartPhone()
    {
    }

    public static function isTablet()
    {
    }

    public static function isAndroid()
    {
    }

    public static function isIos()
    {
    }

    public static function isBlackBerry()
    {
    }

    public static function isFeaturePhone()
    {
        return false;
    }

    public static function isFpDocomo()
    {
    }

    public static function isFpKddi()
    {
    }

    public static function isFpSoftbank()
    {
    }

    public static function isPc()
    {
    }

    public static function isInternetExplorer()
    {
    }

    public static function isFireFox()
    {
    }

    public static function isGoogleChrome()
    {
    }

    public static function isCrawler()
    {
    }

    public static function isSimurator()
    {
    }

    public static function valueOf()
    {
        return AppEnvironment::getInstance()->getServerGlobal("HTTP_USER_AGENT");
    }
}
