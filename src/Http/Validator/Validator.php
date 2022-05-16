<?php

declare(strict_types=1);

namespace App\Http\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Validator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(object $object): void
    {        
        $violations = $this->validator->validate($object->url, [new Regex([
            'pattern' => '/(https?:\/\/)?(www\.)?([-а-яa-z0-9_\.]{2,}\.)(рф|[a-z]{2,6})((\/[-а-яa-z0-9_]{1,})?\/?([a-z0-9_-]{2,}\.[a-z]{2,6})?(\?[a-z0-9_]{2,}=[-0-9]{1,})?((\&[a-z0-9_]{2,}=[-0-9]{1,}){1,})?)/i'
            ]),
            new NotBlank()]);
        
        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }
}
