<?php
/**
 * @buief ユーザーエラー例外
 * @details ユーザーエラー例外
 * この例外は入力エラーをハンドリングするものであり、
 * 決して致命的ではない。
 * 
 * @since 2014
 * @package Onota0318
 */

namespace Onota0318\Exception;

use Onota0318\Message\Message;

class InputValidationException extends \Exception
{
    /**
     * @var array メッセージオブジェクト保持配列
     */
    private $messageCollection = array();
    
    /**
     * メッセージを詰める
     * 
     * @param Message $message メッセージ
     */
    public function addMessage($key, Message $message)
    {
        $this->messageCollection[$key] = $message;
    }
    
    /**
     * エラーがあるか確認
     * 
     * @return boolean true:エラーあり false:エラーなし
     */
    public function hasErrors()
    {
        return count($this->messageCollection) > 0;
    }
    
    /**
     * エラー情報を取得
     * 
     * @return array エラー配列
     */
    public function getErrors()
    {
        return $this->messageCollection;
    }
}
