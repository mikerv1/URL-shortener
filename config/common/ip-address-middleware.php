<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use RKA\Middleware\IpAddress;

return [
    IpAddress::class => static function (ContainerInterface $container): IpAddress {
        $checkProxyHeaders = false;
        $trustedProxies = []; //['10.0.0.1', '10.0.0.2', '127.0.0.1'];
        return new IpAddress($checkProxyHeaders, $trustedProxies);
    }
];
