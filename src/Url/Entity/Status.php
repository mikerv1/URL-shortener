<?php

declare(strict_types=1);

namespace App\Url\Entity;

use Webmozart\Assert\Assert;

final class Status
{
    public const WAIT = 'wait';
    public const ACTIVE = 'active';
}