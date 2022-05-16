<?php

declare(strict_types=1);

namespace App\Url\Entity;

use DateTimeImmutable;
use App\Url\Entity\Ip;

final class Info
{    
    public function __construct(public ?DateTimeImmutable $receiveDate, public ?DateTimeImmutable $requestDate, public Ip $ip)
    {

    }
}
