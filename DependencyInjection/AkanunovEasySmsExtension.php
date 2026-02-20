<?php

namespace Akanunov\EasySmsBundle\DependencyInjection;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class AkanunovEasySmsExtension extends Extension
{
    /**
     * @var GatewayFactoryInterface[]
     */
    private $gatewayFactories;

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('factories.yaml');
        $gatewayFactories = $this->getFactories($container, $configs);
        $configuration = new Configuration($gatewayFactories);
        $config = $this->processConfiguration($configuration, $configs);
        $loader->load('easy_sms.yaml');

        $easySmsDefinition = $container->getDefinition('akanunov_easy_sms.easy_sms');
        $easySmsDefinition->replaceArgument(0, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('factories.yaml');
        $gatewayFactories = $this->getFactories($container, $configs);

        return new Configuration($gatewayFactories);
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return GatewayFactoryInterface[]
     *
     * @throws \Exception
     */
    private function getFactories(ContainerBuilder $container, array $configs)
    {
        if (null !== $this->gatewayFactories) {
            return $this->gatewayFactories;
        }
        $factories = [];
        $services = $container->findTaggedServiceIds('akanunov_easy_sms.gateway_factory');
        foreach (array_keys($services) as $id) {
            $factory = $container->get($id);
            $names = explode('.', $id);
            $key = array_pop($names);
            $factories[str_replace('-', '_', $key)] = $factory;
        }

        if (isset($configs[0]['custom_gateways']) && is_array($configs[0]['custom_gateways'])) {
            foreach ($configs[0]['custom_gateways'] as $name => $customGateway) {
                $factories[$name] = new $customGateway['configuration_factory_class']();
            }
        }

        return $this->gatewayFactories = $factories;
    }
}
