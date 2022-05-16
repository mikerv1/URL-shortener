<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;

use Symfony\Component\VarDumper\VarDumper;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

//if (getenv('SENTRY_DSN')) {
//    Sentry\init(['dsn' => getenv('SENTRY_DSN')]);
//}

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';
//VarDumper::dump($container); exit;
$app = (require __DIR__ . '/../config/app.php')($container);
//VarDumper::dump($app); exit;
$app->run();
