<?php
/**
 * @buief StrategyFactory
 * @details Smarty用のStrategyFactory
 * ZSmartyがクソ過ぎるのでソースを基に改修
 * 
 * @package Onota0318
 * @since 2014.12
 */
namespace Onota0318\Zend2Adapter\View\Smarty;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver\TemplatePathStack;

class SmartyStrategyFactory implements FactoryInterface
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Onota0318\Zend2Adapter\View\Smarty\SmartyStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        
        $smartyConfig = array();
        if (isset($config['smarty'])) {
            $smartyConfig = $config['smarty'];
        }
        
        $sr = new SmartyRenderer(null, $smartyConfig);
        $resolver = $serviceLocator->get('ViewResolver');
        
        // pull template names to resolve later
        $layouts = array();
        if (isset($config['view_manager'])
                && isset($config['view_manager']["template_map"])) {
            $layouts = $config['view_manager']['template_map'];
        }
        
        // Switch SM-generated TemplatePathStack to use .tpl for extension
        foreach ($resolver->getIterator() as $listener) {
            if ($listener instanceof TemplatePathStack) {
                $listener->setDefaultSuffix('tpl');
            }
        }
        
        $sr->setResolver($resolver);
        $sr->setHelperPluginManager($serviceLocator->get('ViewHelperManager'));
        return new SmartyStrategy($sr, $layouts);
    }
}