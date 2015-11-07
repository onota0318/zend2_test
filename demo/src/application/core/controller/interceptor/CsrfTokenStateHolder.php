<?php
/**
 * @buief
 * @details zend2 CSRF対策　トークンセッションホルダ
 * 
 * @package Core
 * @since 2014.12
 */

namespace Core\Controller\Interceptor;

use Onota0318\Holder\AbstractStateHolder;

class CsrfTokenStateHolder extends AbstractStateHolder
{
    /**
     * @var string トークン 
     */
    protected $token = "";
    
    /**
     * @var string トークンのシード 
     */
    protected $seed = "";
}
