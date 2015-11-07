<?php
/**
 * @buief Adapter生成
 * @details Adapter生成
 * 単純なabstract factoryではなく、SharedAdapterProviderから取得
 * PHPUnit問題の対策＆マルチDB対策用
 * 
 * @package Onota0318
 * @since 2014.12
 * @see http://ngyuki.hatenablog.com/entry/2013/10/06/212553
 */

namespace Onota0318\Zend2Adapter\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\AdapterAbstractServiceFactory;

class SharedAdapterAbstractFactory extends AdapterAbstractServiceFactory
{
    /**
     * アダプタ生成
     *
     * @param  ServiceLocatorInterface $services
     * @param  string $name
     * @param  string $requestedName
     * @return Adapter
     */
    public function createServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        if (!SharedAdapterProvider::has($requestedName)) {
            $adapter = parent::createServiceWithName($services, $name, $requestedName);
            SharedAdapterProvider::set($adapter, $requestedName);
        }
        
        return SharedAdapterProvider::get($requestedName);
    }
}