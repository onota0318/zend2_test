<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

$env = \Onota0318\Environment\AppEnvironment::getInstance();

return array(
    //���[�e�B���O���`
    'router'         => include __DIR__ . "/router.config.php",
    'db'             => include __DIR__ . "/database.config.php",
);
