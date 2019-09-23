<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory\Gateway;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class YuntongxunFactory implements GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('app_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('account_sid')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('account_token')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('is_sub_account')
                    ->defaultFalse()
                ->end()
            ->end()
        ;
    }
}
