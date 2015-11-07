<?php
/**
 * @buief エラーヘルパー
 * @details エラーヘルパー
 * ErrorsScreenHolderとセットで使用。
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Onota0318\Message\Message;

class ErrorsHelper extends AbstractHelper
{
    /**
     * @var string ホルダ名
     */
    const HOLDER_NAME = "ErrorsScreenHolder";
    
    /**
     * @var ErrorsScreenHolder ホルダ
     */
    private $holder = null;
    
    /**
     * 
     * @param type $key
     */
    public function has($key)
    {
        if (!$this->isAssigned()) {
            return false;
        }

        return isset($this->holder->errors[$key])
                && ($this->holder->errors[$key] instanceof Message);
    }
    
    /**
     * エラーが存在するのか？
     * 
     * @return boolean
     */
    public function exists()
    {
        if (!$this->isAssigned()) {
            return false;
        }
        
        return count($this->holder->errors) >= 1;
    }
    
    /**
     * 
     * @param type $key
     */
    public function show($key)
    {
        if (!$this->has($key)) {
            return "";
        }
        
        return $this->holder->errors[$key]->getMessage();
    }
    
    /**
     * アサインされてるか？
     * 
     * @return boolean
     */
    private function isAssigned()
    {
        $this->disposeHolder();
        return !($this->holder === null);
    }
    
    /**
     * holderオブジェクトをセット
     * 
     * @return void
     */
    private function disposeHolder()
    {
        $name = self::HOLDER_NAME;
        if (!isset($this->getView()->$name)) {
            return;
        }
        
        $this->holder = $this->getView()->$name;
    }
}
