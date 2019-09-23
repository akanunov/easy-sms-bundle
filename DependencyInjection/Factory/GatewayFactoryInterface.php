<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;

interface GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $builder);
}
