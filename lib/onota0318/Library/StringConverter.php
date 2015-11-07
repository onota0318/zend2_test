<?php
/**
 * @buief 文字列操作
 * @details 安全に文字列を扱うためのクラス
 * UTF8限定です・・・
 * 
 * @since 2014
 * @package Onota0318
 */
namespace Onota0318\Library;

use Onota0318\Constants\MasterConstants;

class StringConverter
{
    /**
     * @var string 下駄文字
     */
    const REPLACED_GAIJI_CHAR = '〓';
    
    /**
     * @var string SJIS文字コード
     */
    const SJIS_ENCODING = 'sjis-win';
    
    /**
     * @var array 文字コードレンジ 
     */
    private static $sjisRangeList = array(
         "/[\\x89-\\x97\\x99-\\x9F\\xE0-\\xE9][\\x40-\\x7E\\x80-\\xFC]/"
        ,"/\\x81[\\x40-\\x7E\\x80-\\xAC\\xB8-\\xBF\\xC8-\\xCE\\xDA-\\xE8\\xF0-\\xF7\\xFC]/"
        ,"/\\x82[\\x4F-\\x58\\x60-\\x79\\x81-\\x9A\\x9F-\\xF1]/"
        ,"/\\x83[\\x40-\\x7E\\x80-\\x96\\x9F-\\xB6\\xBF-\\xD6]/"
        ,"/\\x84[\\x40-\\x60\\x70-\\x7E\\x80-\\x91\\x9F-\\xBE]/"
        ,"/\\x88[\\x9F-\\xFC]/"
        ,"/\\x98[\\x40-\\x72\\x9F-\\xFC]/"
        ,"/\\xEA[\\x40-\\x7E\\x80-\\xA4]/"
    );

    /**
     * 文字列に外字が含まれているか
     * @param string $target  文字列
     *
     * @return boolean true  外字あり
     *                 false 外字なし
     */
    public static function hasGaiji($target)
    {
        if (preg_match("/". self::REPLACED_GAIJI_CHAR ."/ui", $target)) {
            return true;
        }
        
        $str = mb_convert_encoding($target, self::SJIS_ENCODING, mb_internal_encoding());
        $len = mb_strlen($str, self::SJIS_ENCODING);

        if ($len <= 0) {
            return false;
        }
        
        for ($iii = 0; $iii < $len; ++$iii) {
            if (self::isGaiji(mb_substr($str, $iii, 1, self::SJIS_ENCODING))) {
                return true;
            }
        }

        return false;
    }

    /**
     * 文字列中の外字を変換
     * @param string $target  文字列（UTF-8）
     * @return string  外字変換後 文字列
     */
    public static function replaceGaiji($target)
    {
        $gaiji = self::REPLACED_GAIJI_CHAR;
        
        $str = mb_convert_encoding($target, self::SJIS_ENCODING, mb_internal_encoding());
        $len = mb_strlen($str, self::SJIS_ENCODING);
        
        if ($len <= 0) {
            return "";
        }
        
        $res = "";
        for ($iii = 0; $iii < $len; ++$iii) {
            $sjis = mb_substr($str, $iii, 1, self::SJIS_ENCODING);
            $utf8 = mb_substr($target, $iii, 1);
            
            if (self::isGaiji($sjis)) {
                $res .= $gaiji;
            } else {
                $res .= $utf8;
            }
        }

        return $res;
    }

    /**
     * 外字判定（JIS第1、第2以外）
     *
     * @param string $target  文字（SJIS）
     *
     * @return boolean true  外字
     *                 false 外字以外
     */
    private static function isGaiji($target)
    {
        if (strlen($target) < 2) {
            return false;
        }

        if (false === mb_detect_encoding($target, array('SJIS-win', 'SJIS'))) {
            return false;
        }
        
        foreach (self::$sjisRangeList as $val) {
            if (mb_strlen(preg_replace($val, "", $target)) !== mb_strlen($target)) {
                return false;
            }
        }

        return true;
    }    
    
    /**
     * サロゲートペア（Unicode4byte文字）が存在するか？
     * 
     * @param string $target 対象文字列
     * @return boolean true：存在する　false：存在しない
     */
    public static function hasSurrogatePair($target)
    {
        $length = mb_strlen($target);

        if ($length <= 0) {
            return false;
        }
        
        for ($iii = 0; $iii < $length; ++$iii) {
            if (self::isSurrogatePair(mb_substr($target, $iii, 1))) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * サロゲートペア文字か判定
     * 
     * @param string $target 対象文字
     * @return boolean true:サロゲートペア false:そうではない
     */
    public static function isSurrogatePair($target)
    {
        return strlen($target) >= 4;
    }
    
    /**
     * 安全ではない文字を削除
     * 
     * @param string $target 対象文字列
     * @return string 削除した値
     */
    public static function removeUnsafeCharacter($target)
    {
        $target = self::convertXss($target);
        $target = self::removeControlCode($target);
        $target = self::removeCrlf($target);
        $target = self::replaceGaiji($target);
        
        return $target;
    }
    
    /**
     * XSS対策変換
     * 
     * @param string $target
     * @return string 変換後文字
     */
    public static function convertXss($target)
    {
        $list = array(
            "\"" => "”",
            "'"  => "’",
            "<"  => "＜",
            ">"  => "＞",
        );
        
        foreach ($list as $key => $value) {
            $target = mb_ereg_replace($key, $value, $target);
        }
        
        return $target;
    }
    
    /**
     * 上位ディレクトリ表記（../）を削除
     * 
     * @param string $target 対象文字
     * @return string 削除した文字
     */
    public static function removeParentDirectoryPaths($target)
    {
        return str_replace("..", "", $target);
    }
    
    /**
     * 制御コード削除
     *
     * @param string $target  文字列
     * @return string  制御コード削除後文字列
     */
    public static function removeControlCode($target)
    {
        if (strlen($target) <= 0) {
            return "";
        }

        //制御コード削除
        $pattern = "[\\x00-\\x08]|[\\x0B-\\x0C]|[\\x0E-\\x1F]";
        $target = mb_ereg_replace($pattern, "", $target);

        //スペースやタブだけの文字列は許可しない
        $pattern = "[\\x00]|[\\x09]|[\\x0D]|[\\x0A]|[\\x20]";
        $work = mb_ereg_replace($pattern, "", $target);

        if (strlen($work) <= 0) {
            return "";
        }

        //タブをスペース変換
        $pattern = "[\\x09]";
        $target = mb_ereg_replace($pattern, " ", $target);

        return $target;
    }
    
    /**
     * 改行を削除
     * 
     * @param string $target 文字列
     * @return string 改行を削除した文字列
     */
    public static function removeCrlf($target)
    {
        if (!is_string($target)) {
            return "";
        }
        
        return mb_ereg_replace("\r\n|\r|\n", "", $target);
    }
    
    /**
     * 文字列比較（前方一致）
     * @param string $str  検索対象文字列
     * @param string $key  検索文字
     *
     * @return boolean  true  マッチ
     *                  false アンマッチ
     */
    public static function startsWith($str, $key)
    {
        $len = mb_strlen($key);
        return mb_substr($str, 0, $len) === $key;
    }

    /**
     * 文字列比較（後方一致）
     * @param string $str  検索対象文字列
     * @param string $key  検索文字
     *
     * @return boolean  true  マッチ
     *                  false アンマッチ
     */
    public static function endsWith($str, $key)
    {
        $len = mb_strlen($key);
        $len = $len * -1;
        return mb_substr($str, $len) === $key;
    }
    
    /**
     * クラスパスから上位ネームスペースを取得
     * 
     * @param string $path パス
     * @return string 上位ネームスペース
     */
    public static function getVendorNamespace($path)
    {
        if (strlen($path) <= 0) {
            return "";
        }
        
        //php <= 5.3.2対応
        if (self::startsWith($path, MasterConstants::NS)) {
            $path = substr($path, strlen(MasterConstants::NS));
        }
        
        $path = self::removeParentDirectoryPaths($path);
        $tmp  = explode(MasterConstants::NS, $path);
        return trim($tmp[0]);
    }
    
    /**
     * ハッシュ化（sha256固定）
     * 
     * @param string $target 対象文字
     * @param int $stratching ストレッチングする回数（デフォ:2回）
     */
    public static function hash($target, $stratching = 2)
    {
        if (strlen($target) <= 0) {
            return "";
        }
        
        if ($stratching < 2
                || !is_numeric($stratching)) {
            $stratching = 2;
        }
        
        for ($iii = 0; $iii < $stratching; ++$iii) {
            $target = hash('sha256', $target);
        }
        
        return $target;
    }
}
