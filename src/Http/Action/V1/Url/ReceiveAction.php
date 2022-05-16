<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Url;

use App\Url\Query\FindDataByHash\Fetcher;
use App\Url\Command\ReceiveUrl\Request\Handler;
use App\Url\Entity\UrlRepository;
use App\Url\Entity\Info;
use App\Url\Entity\Ip;
use App\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Slim\Routing\RouteContext;
use DateTimeImmutable;

use Symfony\Component\VarDumper\VarDumper;

final class ReceiveAction implements RequestHandlerInterface
{    
    private Handler $handler;
    private ?Fetcher $url;
    private UrlRepository $repo;

    public function __construct(
        Fetcher $url,
        UrlRepository $repo,
        Handler $handler
        )
    {        
        $this->url = $url;
        $this->repo = $repo;
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        
        $hash = $route->getArgument('hash');
        
        if (strcmp(mb_substr($hash, -1), '+') == 0) {
            $dataUrl = $this->url->fetch(substr($hash, 0, -1));
            return new JsonResponse($dataUrl);
        }
        
        $url = $this->repo->getByHash($hash);
        
        if (!filter_var($request->getAttribute('ip_address'), FILTER_VALIDATE_IP)) {
            return new JsonResponse("Ip is't ......");
        }

        $ip = new Ip($request->getAttribute('ip_address'));
        
        $info = new Info(new DateTimeImmutable(), null, $ip);
        
        $this->handler->handle($url, $info);
        
        return new JsonResponse($url->getUrl());
    }
}
