<?php

declare(strict_types=1);

use App\Http\Middleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use RKA\Middleware\IpAddress;

return static function (App $app): void {
    $app->add(Middleware\DomainExceptionHandler::class);
    $app->add(IpAddress::class);
    $app->add(Middleware\ValidationExceptionHandler::class);
    $app->add(Middleware\ClearEmptyInput::class);
    $app->addBodyParsingMiddleware();
    $app->add(ErrorMiddleware::class);
};
