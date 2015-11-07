<?php
/**
 * @buief ViewModel
 * @details Smarty用のViewModel
 * ZSmartyがクソ過ぎるのでソースを基に改修
 * 
 * @package Onota0318
 * @since 2014.12
 */
namespace Onota0318\Zend2Adapter\View\Smarty;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SmartyViewModelFactory implements FactoryInterface
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Onota0318\Zend2Adapter\View\Smarty\SmartyModel
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return (new SmartyModel())->setTerminal(true);
    }
}