<?php

namespace Simpleweb\SaaSBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SimplewebSaaSExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('simple_saas.subscription.class', $config['subscription']['class']);
        $container->setParameter('simple_saas.plan.class', $config['plan']['class']);
        $container->setParameter('simple_saas.user.class', $config['user']['class']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('form_types.yml');
        $loader->load('event_listeners.yml');
        $loader->load('managers.yml');
    }
}
