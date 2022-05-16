<?php

declare(strict_types=1);

namespace App\Url\Command\RequestUrl\Request;

use App\Url\Entity\Url;
use App\Url\Command\RequestUrl\Request\Command;
use App\Flusher;
use App\Url\Entity\UrlRepository;
use DateTimeImmutable;
use DomainException;
use Spatie\Url\Url as DividedUrl;
use App\Url\Entity\Info;
use App\Url\Entity\Ip;

use function App\urlToArray;

use Symfony\Component\VarDumper\VarDumper;

final class Handler
{
    private UrlRepository $urls;
    private Flusher $flusher;

    public function __construct(
        UrlRepository $urls,
        Flusher $flusher
    ) {
        $this->urls = $urls;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $creationDate = new DateTimeImmutable();
        
        $expirationDate = $creationDate->add(new \DateInterval('P1M'));
        
        $dividedUrl = DividedUrl::fromString($command->url);
        
        $partsUrl = urlToArray($dividedUrl);
        
        $ip = new Ip($command->ip);
        
        $info = new Info(null, new DateTimeImmutable(), $ip);
        
        $url = Url::createUrl($creationDate,
            $command->url,
            $command->hash,
            $expirationDate,
            $partsUrl['utmSource'],
            $partsUrl['utmMedium'],
            $partsUrl['utmCampaing'],
            $partsUrl['utmTerm'],
            $partsUrl['utmContent'],
            $info
        );
        
        $this->urls->add($url);

        $this->flusher->flush();
    }
    
    public function addInfo($url, $command): void
    {
        $ip = new Ip($command->ip);
        
        $url->attachInfo(new info(null, new DateTimeImmutable(), $ip));
        
        $this->urls->add($url);

        $this->flusher->flush();
    }
}
