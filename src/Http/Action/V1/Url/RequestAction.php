<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Url;

use App\Url\Command\RequestUrl\Request\Command;
use App\Url\Command\RequestUrl\Request\Handler;
use App\Url\Query\FindUrlByHash\Fetcher;
use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use App\Url\Entity\UrlRepository;

//use Symfony\Component\VarDumper\VarDumper;

final class RequestAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;    
    private ?Fetcher $urls;
    
    private UrlRepository $repo;

    public function __construct(Validator $validator,
        Fetcher $urls,
        Handler $handler,
        UrlRepository $repo
        )
    {        
        $this->validator = $validator;
        $this->urls = $urls;
        $this->handler = $handler;
        $this->repo = $repo;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var array{url:?string} $data
         */
        if (is_string($data = $request->getParsedBody())) {
            return new JsonResponse("url is't a string");            
        }
        
        try{
            $command = new Command($data['url']);
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            return new JsonResponse($e->getMessage());
        }        

        try {
            $this->validator->validate($command);
        } catch (ValidationException $e) {
            return new JsonResponse($e->getMessage());
        }

        $command->hash = substr(md5($command->url), 0, 8);

        if (!filter_var($request->getAttribute('ip_address'), FILTER_VALIDATE_IP)) {
            return new JsonResponse("Ip is't ......");
        }

        $command->ip = $request->getAttribute('ip_address');
        
        $url = $this->repo->getByHash($command->hash);
        
        if ($url === null) {
            $this->handler->handle($command);

            return new JsonResponse($command->hash);
        }
        
//        try {
           $this->handler->addInfo($url, $command);
//        } catch (ValidationException $e) {
//            return new JsonResponse($e->getMessage());
//        }

        return new JsonResponse($url->getHash());
    }
}
