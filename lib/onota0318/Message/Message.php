<?php
/**
 * @buief メッセージ管理
 * @details メッセージ管理
 * 
 * @since 2014
 * @package Onota0318
 */

namespace Onota0318\Message;

use Onota0318\Library\StringConverter;

class Message
{
    /**
     * @var array メッセージ配列 
     */
    private static $messageList = array();
    
    /**
     * @var string メッセージコード 
     */
    private $code = "";
    
    /**
     * @var array フォーマット 
     */
    private $format = array();
    
    /**
     * @var string メッセージ 
     */
    private $message = "";
    
    /**
     * メッセージ外部ファイルをセットする。
     * メンバ$messageに値がない場合は、メンバ$codeをキーにファイルから取得
     * 
     * @param string $file ファイルパス
     */
    public static function setMessageFile($file)
    {
        self::generateMessageList(
            StringConverter::removeParentDirectoryPaths($file)
        );
    }
    
    /**
     * メッセージファイルからメッセージを取得
     * 
     * @param string $code
     * @param array $format
     * @return string メッセージ
     */
    public static function getStaticMessage($code, array $format = array())
    {
        if (count(self::$messageList) <= 0) {
            return "";
        }
        
        $message = new self();
        $message->setCode($code);
        $message->setFormat($format);
        return $message->getMessage();
    }
    
    /**
     * コードをセットする。
     * 
     * @param string $code メッセージコード
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * 変換文字をセットする。
     * 
     * @param array $format フォーマット
     */
    public function setFormat(array $format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * メッセージをセットする。
     * 
     * @param string $message メッセージ
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    
    /**
     * メッセージを取得する。
     * 
     * @return string メッセージ
     */
    public function getMessage()
    {
        $this->disposeMessage();
        return vsprintf($this->message, $this->format);
    }
    
    /**
     * メッセージを配置
     * 
     * @return void
     * @throws \InvalidArgumentException
     */
    private function disposeMessage()
    {
        //メンバにあればOK
        if (strlen($this->message) > 0) {
            return;
        }
        
        if (strlen($this->code) <= 0) {
            throw new \InvalidArgumentException(
                 "メッセージコードが定義されていません！"
            );
        }

        if (!isset(self::$messageList[$this->code])) {
            throw new \InvalidArgumentException(
                 "該当するメッセージが存在しません！"
                ."コード[" . $this->code . "]"
            );
        }
        
        $this->message = self::$messageList[$this->code];
    }
    
    /**
     * ファイルからメッセージリストを作成
     * 
     * @param string $file ファイル
     * @throws \InvalidArgumentException
     */
    private static function generateMessageList($file)
    {
        clearstatcache();
        if (!is_file($file)
                || !is_readable($file)) {
            throw new \InvalidArgumentException(
                 "メッセージファイルが読み込めません！"
                ."ファイル[" . $file . "]"
            );            
        }
        
        $list = parse_ini_file($file);
        if (false === $list) {
            throw new \InvalidArgumentException(
                 "メッセージファイルが読み込めません！"
                ."ファイル[" . $file . "]"
            );
        }
        
        foreach ($list as $code => $message) {
            self::$messageList[$code] = $message;
        }
    }
}
