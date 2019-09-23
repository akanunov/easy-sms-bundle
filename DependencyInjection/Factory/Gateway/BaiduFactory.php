<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory\Gateway;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class BaiduFactory implements GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('ak')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('sk')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('invoke_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('domain')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
    }
}
