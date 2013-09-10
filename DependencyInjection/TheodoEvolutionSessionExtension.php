<?php

namespace Theodo\Evolution\Bundle\SessionBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class TheodoEvolutionSessionExtension extends Extension
{
    /**
     * @var \Symfony\Component\DependencyInjection\Loader\YamlFileLoader
     */
    private $loader;

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $this->loader->load('session.xml');

        $this->addBagManager($container, $config);
    }

    public function addBagManager($container, $configs)
    {
        $container
            ->getDefinition('theodo_evolution.session.bag_manager_configuration')
            ->addMethodCall('setNamespaces', $configs['namespaces'])
        ;

        $container->setParameter(
            'theodo_evolution.session.bag_manager.class',
            $configs['bag_manager']['class']
        );
        $container->setParameter(
            'theodo_evolution.session.bag_manager_configuration.class',
            $configs['bag_manager']['configuration_class']
        );
    }
}
