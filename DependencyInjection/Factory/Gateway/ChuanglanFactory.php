<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory\Gateway;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class ChuanglanFactory implements GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('account')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('password')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('intel_account')->end()
                ->scalarNode('intel_password')->end()
                ->scalarNode('channel')->end()
                ->scalarNode('sign')->end()
                ->scalarNode('unsubscribe')->end()
            ->end()
        ;
    }
}
