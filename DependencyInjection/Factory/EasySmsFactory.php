<?php

namespace Akanunov\EasySmsBundle\DependencyInjection\Factory;

use Overtrue\EasySms\EasySms;

class EasySmsFactory
{
    /**
     * @param array $config
     *
     * @return EasySms
     */
    public static function createEasySms(array $config)
    {
        $customGateways = $config['custom_gateways'];
        unset($config['custom_gateways']);
        $easySms = new EasySms($config);
        foreach ($customGateways as $name => $customGateway) {
            $easySms->extend($name, function ($gatewayConfig) use ($customGateway) {
                return new $customGateway['gateway_class']($gatewayConfig);
            });
        }

        return $easySms;
    }
}
