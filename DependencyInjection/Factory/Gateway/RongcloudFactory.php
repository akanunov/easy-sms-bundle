<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory\Gateway;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class RongcloudFactory implements GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('app_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('app_secret')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
    }
}
