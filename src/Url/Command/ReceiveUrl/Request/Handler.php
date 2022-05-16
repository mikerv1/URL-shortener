<?php

declare(strict_types=1);

namespace App\Url\Command\ReceiveUrl\Request;

use App\Flusher;
use App\Url\Entity\UrlRepository;

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

    public function handle($url, $info): void
    {
        $url->attachInfo($info);
        
        $this->urls->add($url);

        $this->flusher->flush();
    }
}
