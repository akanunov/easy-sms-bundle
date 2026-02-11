<?php

namespace Akanunov\EasySmsBundle\DependencyInjection;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Overtrue\EasySms\Strategies\OrderStrategy;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var GatewayFactoryInterface[]
     */
    protected $gatewayFactories;

    public function __construct(array $gatewayFactories)
    {
        $this->gatewayFactories = $gatewayFactories;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('akanunov_easy_sms');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('akanunov_easy_sms');
        }

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->floatNode('timeout')
                    ->defaultValue(5.0)
                    ->min(1.0)
                ->end()
                ->arrayNode('default')
                    ->addDefaultsIfNotSet()
                    ->isRequired()
                    ->children()
                        ->scalarNode('strategy')
                            ->cannotBeEmpty()
                            ->defaultValue(OrderStrategy::class)
                        ->end()
                        ->arrayNode('gateways')
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('custom_gateways')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('gateway_class')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                            ->scalarNode('configuration_factory_class')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        $this->addGatewaySection($rootNode);

        return $treeBuilder;
    }

    private function addGatewaySection(ArrayNodeDefinition $node): void
    {
        $gatewayNodeBuilder = $node
            ->fixXmlConfig('gateway')
            ->children()
                ->arrayNode('gateways')
                    ->performNoDeepMerging()
                    ->children()
        ;
        foreach ($this->gatewayFactories as $name => $factory) {
            $factoryNode = $gatewayNodeBuilder->arrayNode($name)->canBeUnset();
            $factory->addConfiguration($factoryNode);
        }
    }
}
