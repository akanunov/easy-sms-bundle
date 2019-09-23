<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory\Gateway;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class HuaweiFactory implements GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('endpoint')->isRequired()->end()
                ->scalarNode('app_key')->isRequired()->end()
                ->arrayNode('from')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->scalarPrototype()->end()
                ->end()
                ->scalarNode('callback')->isRequired()->end()
            ->end()
        ;
    }
}
