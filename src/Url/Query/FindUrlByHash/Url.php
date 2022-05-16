<?php

declare(strict_types=1);

namespace App\Url\Query\FindUrlByHash;

/**
 * @psalm-immutable
 */
final class Url
{
    public function __construct(
        public int $id,
        public string $hash,
//        public string $ip,
    ) {
    }
}
