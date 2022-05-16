<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

use Symfony\Component\VarDumper\VarDumper;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/common/*.php'),
    new PhpFileProvider(__DIR__ . '/console/*.php'),
    new PhpFileProvider(__DIR__ . '/' . (getenv('APP_ENV') ?: 'prod') . '/*.php')
]);

return $aggregator->getMergedConfig();
