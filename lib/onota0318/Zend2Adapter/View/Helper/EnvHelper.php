<?php
/**
 * @buief 環境設定ヘルパー
 * @details 環境設定ヘルパー
 * AppEnvironmentの環境ファイルを返却
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Onota0318\Environment\AppEnvironment;

class EnvHelper extends AbstractHelper
{
    /**
     * 環境定義を返却
     * 
     * @param string $key キー
     * @return string 値
     */
    public function __get($key)
    {
        try {
            return AppEnvironment::getInstance()->$key;
        } catch (\InvalidArgumentException $e) {
            return "";
        }
    }
}
