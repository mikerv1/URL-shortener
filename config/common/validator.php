<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

return [
    ValidatorInterface::class => static function (ContainerInterface $container): ValidatorInterface {
        return Validation::createValidator();
    }
];
