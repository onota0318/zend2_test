<?php
/**
 * @buief zend2 コントローラー動的生成処理
 * @details 
 * [module]/config/module.config.phpでは
 * URIから動的にコントローラーを生成する仕組みがない為、
 * このクラスにて生成
 * 
 * @package Onota0318
 * @since 2014.12
 * @see http://samsonasik.wordpress.com/2012/12/23/zend-framework-2-automatic-controller-invokables-via-abstract-factories/
 */

namespace Onota0318\Zend2Adapter\Controller;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Onota0318\Constants\MasterConstants as Consts;

class ControllerAbstractFactory implements AbstractFactoryInterface
{
    /**
     * @var string クラスSAFFIX
     */
    const CLASS_SAFFIX = "Controller";
    
    /**
     * @var string クラス名 
     */
    private $className = "";
    
    /**
     * <pre>
     * <p>[概要]</p>
     * Determine if we can create a service with name
     * </pre>
     * 
     * @param ServiceLocatorInterface $locator locator
     * @param type $name name
     * @param type $requestedName requestedName
     * @return boolean true/false
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $this->className = $requestedName;
        $sl    = $locator->getServiceLocator();
        $route = $sl->get("Application")->getMvcEvent()->getRouteMatch();
        
        $params = $route->getParams();

        if (isset($params["abstract_factory"])) {
            $this->className = $params["__NAMESPACE__"] . Consts::NS . str_replace(DS, Consts::NS, $params["abstract_factory"]);
        }
        
        return class_exists($this->className . self::CLASS_SAFFIX);
    }
 
    /**
     * <pre>
     * <p>[概要]</p>
     * Create service with name
     * </pre>
     * 
     * @param ServiceLocatorInterface $locator locator
     * @param type $name name
     * @param type $requestedName requestedName
     * @return \Onota0318\Zend2Adapter\class instance.
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $class = $this->className . self::CLASS_SAFFIX;
        return new $class;
    }
}
