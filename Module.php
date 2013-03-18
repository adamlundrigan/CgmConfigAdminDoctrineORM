<?php
/**
 * CgmConfigAdminDoctrineORM
 *
 * @link      http://github.com/cgmartin/CgmConfigAdmin for the canonical source repository
 * @copyright Copyright (c) 2012-2013 Christopher Martin (http://cgmartin.com)
 * @license   New BSD License https://raw.github.com/cgmartin/CgmConfigAdmin/master/LICENSE
 */

namespace CgmConfigAdminDoctrineORM;

use CgmConfigAdmin\View\Helper\CgmFlashMessages;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Session\Container as SessionContainer;
use Doctrine\ORM\Mapping\Driver\XmlDriver;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function onBootstrap($e)
    {
        $app = $e->getParam('application');
        $sm  = $app->getServiceManager();
        $opt = $sm->get('cgmconfigadmin_module_options');

        if ($opt->getEnableDefaultEntities()) {
            $chain = $sm->get('doctrine.driver.orm_default');
            $chain->addDriver(new XmlDriver(__DIR__ . '/config/xml/cgmconfigadmindoctrineorm'), 'CgmConfigAdminDoctrineORM\Entity');
        }
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'cgmconfigadmin_doctrine_em' => 'doctrine.entitymanager.orm_default',
            ),
            'factories' => array(
                'cgmconfigadmin_module_options' => function ($sm) {
                    $config = $sm->get('Config');
                    return new Options\ModuleOptions(
                        isset($config['cgmconfigadmin']) ? $config['cgmconfigadmin'] : array()
                    );
                },

                // Data Mapper for config values
                'cgmconfigadmin_configvalues_mapper' => function ($sm) {
                    $mapper = new Entity\ConfigValuesMapper(
                        $sm->get('cgmconfigadmin_doctrine_em'),
                        $sm->get('cgmconfigadmin_module_options')
                    );
                    return $mapper;
                },
            ),
        );
    }

}
