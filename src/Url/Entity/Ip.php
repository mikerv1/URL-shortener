<?php

declare(strict_types=1);

namespace App\Url\Entity;

use Webmozart\Assert\Assert;

final class Ip
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public function isEqualTo(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    
    public function __toString() {
        return $this->value;
    }
}
