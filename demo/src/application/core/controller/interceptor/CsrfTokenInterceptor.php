<?php
/**
 * @buief
 * @details zend2 CSRF対策　トークン用インターセプタ
 * 
 * @package Core
 * @since 2014.12
 */

namespace Core\Controller\Interceptor;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\InterceptorInterface;
use Onota0318\Zend2Adapter\Controller\Interceptor\AbstractInterceptor;
use Onota0318\Exception\CsrfTokenInvalidException;
use Onota0318\Library\DateTimer;
use Onota0318\Library\StringConverter;
use Onota0318\Environment\AppEnvironment;
use Core\Controller\Interceptor\Marker\CsrfTokenVerifyAware;

class CsrfTokenInterceptor extends AbstractInterceptor implements InterceptorInterface
{
    /**
     * @var string トークンテンプレート 
     */
    private $template = '##CSRF_TOKEN_START#%s#CSRF_TOEKN_END##';
    
    /** 
     * {@inheriteDoc}
     * @throws CsrfTokenInvalidException
     */
    public function intercept(AbstractController $instance, ServiceLocatorInterface $locator)
    {
        if (!($instance instanceof Marker\SessionAware)) {
            throw new CsrfTokenInvalidException(
                "セッション機構が有効ではありません。"
            );
        }
        
        //ホルダ
        $holder = $instance->session()->load(CsrfTokenStateHolder::id());

        //トークンチェック
        if ($instance instanceof CsrfTokenVerifyAware) {
            $this->verifyToken($instance, $holder);
        } 
        //トークン生成
        else {
            $this->generateToken($instance, $holder);
        }
    }
    
    /**
     * トークンを生成する
     * 
     * @param AbstractController $instance
     * @param \Core\Controller\Interceptor\CsrfTokenStateHolder $holder
     */
    private function generateToken(AbstractController $instance, CsrfTokenStateHolder $holder)
    {
        $holder->seed  = $this->generateCsrfTokenSeed();
        $holder->token = $this->generateCsrfToken($holder->seed);

        $instance->session()->set($holder);
    }

    /**
     * トークンを検証する
     * 
     * @param AbstractController $instance
     * @param \Core\Controller\Interceptor\CsrfTokenStateHolder $holder
     * @return type
     * @throws CsrfTokenInvalidException
     */
    private function verifyToken(AbstractController $instance, CsrfTokenStateHolder $holder)
    {
        $instance->session()->remove(CsrfTokenStateHolder::id());

        if (strlen($holder->token) <= 0
                || strlen($holder->seed) <= 0) {
            throw new CsrfTokenInvalidException();
        } 
        
        $token = $this->generateCsrfToken($holder->seed);

        if ($holder->token === $token) {
            return;
        }
        
        throw new CsrfTokenInvalidException();
    }

    /**
     * トークンシードを生成
     * @return string シード
     */
    private function generateCsrfTokenSeed()
    {
        $ts   = (new DateTimer())->getTimestamp();
        $addr = AppEnvironment::getInstance()->getServerGlobal('REMOTE_ADDR');
        return StringConverter::hash(uniqid(). $ts . $addr);
    }

    /**
     * シードからトークンを生成
     * @param string $seed シード
     * @return string トークン
     */
    private function generateCsrfToken($seed)
    {
        return StringConverter::hash(sprintf($this->template, $seed));
    }
}
