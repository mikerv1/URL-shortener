<?php

declare(strict_types=1);

use App\Http\Action\V1\Url;
use Slim\App;

return static function (App $app): void {
    $app->post('/', Url\RequestAction::class);
    $app->get('/{hash}', Url\ReceiveAction::class);
};
