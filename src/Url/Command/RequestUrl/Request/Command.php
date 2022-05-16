<?php

declare(strict_types=1);

namespace App\Url\Command\RequestUrl\Request;

use Webmozart\Assert\Assert;

final class Command
{   
    public string $hash;
    
    public string $ip;
    
    public function __construct(public string $url) {
        Assert::notEmpty($url);
        $this->url = mb_strtolower($url, 'UTF-8');
    }
}
