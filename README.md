Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require akanunov/easy-sms-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Akanunov\EasySmsBundle\AkanunovEasySmsBundle(),
        ];

        // ...
    }

    // ...
}
```

Step 3: Configure your SMS gateways
-----------------------------------

```yaml
# app/config/config.yml
akanunov_easy_sms:
    gateways:
      aliyun:
        access_key_id:        "%aliyun_access_key%"
        access_key_secret:    "%aliyun_key_secret%"
        sign_name:            "%aliyun_sign_name%"
    default:
        gateways: ['aliyun']
```

For more details on the other parameters, take a look at the [Easy SMS documentation](https://github.com/overtrue/easy-sms).

Step 4: Configure custom SMS gateway
------------------------------------

Update configuration file:

```yaml
# app/config/config.yml
akanunov_easy_sms:
    gateways:
        mygateway:
            api_key: "%mygateway_api_key%"
    default:
        gateways: ['mygateway']
    custom_gateways:  
        mygateway:
          gateway_class: App\EasySms\Gateways\MyGateway
          configuration_factory_class: App\DependencyInjection\Factory\Gateway\MyGatewayFactory

```

Create gateway configuration factory:

```php
<?php

namespace App\DependencyInjection\Factory\Gateway;

use Akanunov\EasySmsBundle\DependencyInjection\Factory\GatewayFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class MyGatewayFactory implements GatewayFactoryInterface
{
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
    }
}
```
