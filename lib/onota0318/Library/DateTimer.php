<?php
/**
 * @buief 現在操作
 * @details
 *   現在操作
 *
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Library;

use Onota0318\Library\Provider\SystemDateProvider;

final class DateTimer
{
    /**
     * @var DateTime DateTimeオブジェクト
     */
    private $datetime = null;

    /**
     * 現在日付を文字列で取得
     *
     * @param string $format 年月日時分秒フォーマット
     * @return string 現在日付
     */
    public static function getSystemDateTime($format = "")
    {
        return SystemDateProvider::getSystemDateTime($format);
    }

    /**
     * コンストラクタ
     * 指定した時間でインスタンスを初期化
     * 
     * @param string $ymdhis 年月日時分秒
     * @return void
     */
    public function __construct($ymdhis = "")
    {
        if (strlen($ymdhis) <= 0) {
            $ymdhis = self::getSystemDateTime();
        }

        $this->initDatetime($ymdhis);
    }

    /**
     * このインスタンスから年を取得
     * 
     * @return string 年
     */
    public function getYear()
    {
        return $this->format("Y");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから年（下2桁）を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在年月日：2014/02/01
     * $datetime = new DateTimer();
     * $datetime->getShortYear();
     * //$result : 14
     * </code>
     * </pre>
     * @return string 2桁年
     */
    public function getShortYear()
    {
        return $this->format("y");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから月を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在年月日：2014/02/01
     * $date = new DateTimer();
     * $date->getMonth();
     * //$result : 02
     * </code>
     * </pre>
     * @return string 月
     */
    public function getMonth()
    {
        return $this->format("m");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから日を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在年月日：2014/02/01
     * $date = new DateTimer();
     * $date->getDay();
     * //$result : 01
     * </code>
     * </pre>
     * @return string 日
     */
    public function getDay()
    {
        return $this->format("d");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから時を取得（24時間記法）
     * <p>[使用方法]</p>
     * <code>
     * //現在年月日：2014/02/01 13:00:00
     * $date = new DateTimer();
     * $date->getHour();
     * //$result : 13
     * </code>
     * </pre>
     * @return string 時
     */
    public function getHour()
    {
        return $this->format("H");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから分を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在年月日：2014/02/01 12:58:00
     * $date = new DateTimer();
     * $date->getMinute();
     * //$result : 58
     * </code>
     * </pre>
     * @return string 分
     */
    public function getMinute()
    {
        return $this->format("i");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから秒を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在年月日：2014/02/01 12:58:10
     * $date = new DateTimer();
     * $date->getSecond();
     * //$result : 10
     * </code>
     * </pre>
     * @return string 秒
     */
    public function getSecond()
    {
        return $this->format("s");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから曜日を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在日：20140206
     * $date  = new DateTimer();
     * $youbi = $date->getDayOfWeek();
     * //$youbi : 4（木曜日）
     * </code>
     * </pre>
     * @return int 曜日（0 ⇒ 日、1 ⇒ 月、2 ⇒ 火　・・・ 6 ⇒ 土）
     */
    public function getDayOfWeek()
    {
        return $this->format("w");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから該当月の日数を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在日：20140206
     * $date = new DateTimer();
     * $day  = $date->getDaysInMonth();
     * //$day : 28
     * </code>
     * </pre>
     * @return int 日数
     */
    public function getDaysInMonth()
    {
        return $this->format("t");
    }
   
    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスが閏年か判定
     * <p>[使用方法]</p>
     * <code>
     * //現在日：20140206
     * $date = new DateTimer();
     * if ($date->isLeap($date) === true) {
     *     //うるう年
     * } else {
     *     //うるう年ではない
     * }
     * </code>
     * </pre>
     * @return boolean true：うるう年 false：うるう年ではない
     */
    public function isLeap()
    {
        return (boolean)$this->format("L");
    }

    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスからタイムスタンプを返却
     * <p>[使用方法]</p>
     * <code>
     * $date = new DateTimer();
     * $timestamp = $date->getTimestamp();
     * </code>
     * </pre>
     * @return int タイムスタンプ
     */
    public function getTimestamp()
    {
        return $this->datetime->getTimestamp();
    }

    /**
     * 年を加減算する。
     * 
     * @param integer $add 加減算値
     * @return DateTimer コピーしたこのオブジェクト
     */
    public function addYears($add)
    {
        $timestamp = strtotime($add . " year", $this->getTimestamp());
        return $this->generatePrototype($timestamp);
    }

    /**
     * 月を加減算する。
     * 
     * @param integer $add 加減算値
     * @return DateTimer コピーしたこのオブジェクト
     */
    public function addMonths($add)
    {
        $timestamp = strtotime($add . " month", $this->getTimestamp());
        return $this->generatePrototype($timestamp);
    }

    /**
     * 日を加減算する。
     * 
     * @param integer $add 加減算値
     * @return DateTimer コピーしたこのオブジェクト
     */
    public function addDays($add)
    {
        $timestamp = strtotime($add . " day", $this->getTimestamp());
        return $this->generatePrototype($timestamp);
    }

    /**
     * 時間を加減算する。
     * 
     * @param integer $add 加減算値
     * @return DateTimer コピーしたこのオブジェクト
     */
    public function addHours($add)
    {
        $timestamp = strtotime($add . " hour", $this->getTimestamp());
        return $this->generatePrototype($timestamp);
    }

    /**
     * 分を加減算する。
     * 
     * @param integer $add 加減算値
     * @return DateTimer コピーしたこのオブジェクト
     */
    public function addMinutes($add)
    {
        $timestamp = strtotime($add . " minute", $this->getTimestamp());
        return $this->generatePrototype($timestamp);
    }

    /**
     * 秒を加減算する。
     * 
     * @param integer $add 加減算値
     * @return DateTimer コピーしたこのオブジェクト
     */
    public function addSeconds($add)
    {
        $timestamp = strtotime($add . " second", $this->getTimestamp());
        return $this->generatePrototype($timestamp);
    }
    
    /**
     * <pre>
     * <p>[概要]</p>
     * このインスタンスから指定したフォーマットで日付を取得
     * <p>[使用方法]</p>
     * <code>
     * //現在日時：2014/01/08
     * $date = new DateTimer();
     * $months = $date->format("F");
     * //$months : January
     * </code>
     * <p>[概要]</p>
     * 年月日時分秒の取得は、専用のメソッドを用意してあります。
     * 当メソッドを使用せず、用意してある専用のメソッドを使用してください。
     * </pre>
     * @param string $format date関数の第1引数
     * @return string フォーマット後日付
     */
    public function format($format)
    {
        /*
         * @buief
         * PHP公式リファレンス上では、
         * 「不正なフォーマットの場合はfalseを返す」とあるが、
         * 実際はfalseが返却されない。
         * （不正な文字がそのまま返却）
         *
         * そのため、当メソッドでもそのまま返却する。
         */
        return $this->datetime->format($format);
    }

    /**
     * オブジェクトの生成
     * @param string $datetime 年月日時分秒
     * @return void
     */
    private function initDatetime($datetime)
    {
        //セパレータ削除
        $YmdHis = $this->deleteSeparator($datetime);
        $this->datetime = $this->createInstance($YmdHis);
        return;
    }

    /**
     * DateTimerオブジェクトの生成
     *
     * @param string $datetime 年月日時分秒
     * @return DateTimer DateTimerオブジェクト
     *
     * @throws \InvalidArgumentException
     */
    private function createInstance($datetime)
    {
        //インスタンス変数
        $instance = null;

        //DateTime::__constructがExceptionをスローする為、
        //生成失敗時はキャッチしてExceptionを投げる。
        try {
            //$instance = new \DateTime($datetime);
            $instance = date_create($datetime);
        }
        //オブジェクト生成に失敗
        catch (\Exception $e) {

            $message = "DateTimerオブジェクトの生成に失敗しました！"
                     . "引数[".$datetime."]";

            throw new \InvalidArgumentException($message);
        }

        return $instance;
    }

    /**
     * セパレータを削除
     *
     * @param string $datetime 年月日
     * @return string セパレータを削除した文字列
     */
    private function deleteSeparator($datetime)
    {
        $len = strlen($datetime);
        $res = $datetime;

        //セパレータ付き年月日時分秒
        if ($len === strlen("YYYY/mm/dd HH:ii:ss")) {
            $res = substr($datetime,  0, 4)
                 . substr($datetime,  5, 2)
                 . substr($datetime,  8, 2)
                 . substr($datetime, 11, 2)
                 . substr($datetime, 14, 2)
                 . substr($datetime, 17, 2)
                 ;
        }

        //セパレータ付き年月日
        elseif ($len === strlen("YYYY/mm/dd")) {
            $res = substr($datetime, 0, 4)
                 . substr($datetime, 5, 2)
                 . substr($datetime, 8, 2)
                 ;
        }

        return $res;
    }
    
    /**
     * cloneする
     * 
     * @param integer $timestamp タイムスタンプ
     * @return self cloneしたこのオブジェクト
     * 
     * @throws \RuntimeException
     */
    private function generatePrototype($timestamp)
    {
        if (!is_numeric($timestamp)) {
            throw new \RuntimeException(
                "日付オブジェクトの再生成ができません。[". var_export($timestamp, true) ."]"
            );
        }
        
        $date = clone $this;
        
        /* @buief
         * 公式通りfalse判断をかけてはいるが・・・
         * 実際はfalseが返らず、UnixTimestampの初期値が返る・・・
         * （「引数$timestampがnumericじゃない場合」で防いでいるのでOK）
         */
        if (false === $date->datetime->setTimestamp($timestamp)) {
            throw new \RuntimeException(
                "日付オブジェクトの再生成に失敗しました。"
            );
        }
        
        return $date;
    }

    /**
     * prototype
     * deep copyする
     */
    private function __clone()
    {
        $this->datetime = clone $this->datetime;
    }
}
