<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory\Gateway;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class SendcloudFactory implements GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('sms_user')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('sms_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('timestamp')
                    ->defaultFalse()
                ->end()
            ->end()
        ;
    }
}
