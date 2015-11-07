<?php
/**
 * @buief 例外基底
 * @details 例外基底
 * 設定元はModule.phpのonBootstrapにて
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Exception;

use Zend\Mvc\MvcEvent;

abstract class AbstractConsoleExceptionHandler extends AbstractExceptionHandler
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
                //$this->setNotFound($response);
                break;

            case Application::ERROR_CONTROLLER_CANNOT_DISPATCH:
            case Application::ERROR_CONTROLLER_INVALID:
                //$this->setForbidden($response);
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
}
