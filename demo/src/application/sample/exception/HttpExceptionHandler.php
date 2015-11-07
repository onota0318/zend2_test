<?php
/**
 * @buief 例外
 * @details 例外
 * ここで例外の処理を行う
 * 設定元はModule.phpのonBootstrapにて
 * 
 * @package sample
 * @since 2014.12
 */
namespace Sample\Exception;

use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Response;
use Onota0318\Zend2Adapter\Exception\AbstractHttpExceptionHandler;
use Onota0318\Environment\AppEnvironment;

class HttpExceptionHandler extends AbstractHttpExceptionHandler
{
    /**
     * @var string リダイレクト先URL 
     */
    private $redirectUri = "http://192.168.56.4:10080/";

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        //$this->redirectUri = AppEnvironment::getInstance()->base_url . "sample";
    }
    
    /**
     * {@inheriteDocs}
     */
    protected function handleException(Response $response, \Exception $ex)
    {
        $contents = "";
        //開発環境下ではデバッグ表示
        if (AppEnvironment::getInstance()->isDevelopment()) {
            $contents = "これは<font color='red'>開発環境限定</font>のデバッグメッセージです\n\n"
                      . "<b>[error]</b>\n" . get_class($ex) . "\n\n"
                      . "<b>[message]</b>\n" . $ex->getMessage() . "\n\n"
                      . "<b>[trace]</b>\n" . $ex->getTraceAsString();
            $contents = nl2br($contents);
        }

        switch (get_class($ex)) {
            //Not Found例外
            case "Onota0318\Exception\NotFoundException":
                $this->setNotFound($response, $contents);
                break;
            
            //メンテナンス中
            case "Onota0318\Exception\MaintenanceException":
                //$this->setForbidden($response, $contents);
                break;
            
            //未認証
            case "Onota0318\Exception\AuthenticationFailureException";
                $url = AppEnvironment::getInstance()->base_url . "sample/auth/login";
                
                $redirect = $ex->getRedirectUrl();
                if (strlen($redirect) > 0) {
                    $url = $redirect;
                }
                
                $this->setRedirect($response, $url);
                break;
            
            default:
                $this->setRedirect($response, $this->redirectUri);
                break;
        }
    }
    
    /**
     * {@inheriteDocs}
     */
    protected function handleUnknownError(MvcEvent $e)
    {
        $this->setRedirect($e->getResponse(), $this->redirectUri);
    }
}
