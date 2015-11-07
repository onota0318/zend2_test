<?php
/**
 * @buief HTTP例外基底
 * @details HTTP例外基底
 * 設定元はModule.phpのonBootstrapにて
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Exception;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Application;
use Zend\Http\PhpEnvironment\Response;

abstract class AbstractHttpExceptionHandler extends AbstractExceptionHandler
{
    /**
     * {@inheriteDocs}
     */
    public function handle(MvcEvent $e)
    {
        $response = $e->getResponse();
     
        switch ($e->getError()) {
            case Application::ERROR_CONTROLLER_NOT_FOUND:
            case Application::ERROR_ROUTER_NO_MATCH:
                $this->setNotFound($response);
                break;

            case Application::ERROR_CONTROLLER_CANNOT_DISPATCH:
            case Application::ERROR_CONTROLLER_INVALID:
                $this->setForbidden($response);
                break;
            
            case Application::ERROR_EXCEPTION:
                $this->handleException($response, $e->getResult()->exception);
                break;
            
            default:
                $this->handleUnknownError($e);
                break;
        }
        
        return $response;
    }

    /**
     * 例外処理
     * 
     * @param Response $response レスポンス
     * @param \Exception $ex 例外クラス
     * @return void
     */
    abstract protected function handleException(Response $response, \Exception $ex);

    /**
     * どれにも分類されないエラー
     * 
     * @param MvcEvent $e MvcEvent
     * @return void
     */
    abstract protected function handleUnknownError(MvcEvent $e);
    
    /**
     * リダイレクト設定
     * 
     * @param Response $response レスポンス
     * @param string $url URL
     */
    protected function setRedirect(Response $response, $url)
    {
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(Response::STATUS_CODE_302);
    }
    
    /**
     * Not Foundにする
     * 
     * @param Response $response レスポンス
     * @param string $contents 表示するコンテンツ
     */
    protected function setNotFound(Response $response, $contents = "") 
    {
        $this->setHttpStatus($response, Response::STATUS_CODE_404, $contents);
    }

    /**
     * Forbiddenにする
     * 
     * @param Response $response レスポンス
     * @param string $contents 表示するコンテンツ
     */
    protected function setForbidden(Response $response, $contents = "")
    {
        $this->setHttpStatus($response, Response::STATUS_CODE_403, $contents);
    }

    /**
     * Unauthorizedにする
     * 
     * @param Response $response レスポンス
     * @param string $contents 表示するコンテンツ
     */
    protected function setUnauthorized(Response $response, $contents = "")
    {
        $this->setHttpStatus($response, Response::STATUS_CODE_401, $contents);
    }
    
    /**
     * 任意のステータスにする
     * 
     * @param Response $response レスポンス
     * @param integer $status HTTPステータス
     * @param string $contents 表示するコンテンツ
     */
    protected function setHttpStatus(Response $response, $status, $contents = "")
    {
        try {
            $response->setStatusCode($status);

            if (strlen($contents) <= 0) {
                $contents = $this->getReasonPhrase($response);
            }
            
            $response->setContent($contents);
        }

        //エラーのエラーはさすがに拾えない・・・
        catch (\Exception $e) {
            $this->setHttpStatus($response, Response::STATUS_CODE_500, $contents);
        }
    }
    
    /**
     * HTTPステータスフレーズを取得
     * 
     * @param Response $response レスポンス
     * @return string 表示するコンテンツ
     */
    private function getReasonPhrase(Response $response)
    {
        return '<h1>' . $response->getReasonPhrase() . '</h1>';
    }
}
