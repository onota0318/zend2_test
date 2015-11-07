<?php
/**
 * @buief 未認証例外
 * @details 未認証例外
 * 
 * @since 2014
 * @package Onota0318
 */

namespace Onota0318\Exception;

class AuthenticationFailureException extends \Exception
{
    /** @var string 遷移先URL */
    private $redirectUrl = "";
    
    /**
     * 遷移先URLをセットする
     * @param string $url URL
     */
    public function setRedirectUrl($url)
    {
        $this->redirectUrl = $url;
    }
    
    /**
     * 遷移先URLを取得する。
     * 
     * @return string 遷移先URL
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
}
