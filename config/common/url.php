<?php

declare(strict_types=1);

use App\Url\Entity\Url;
use App\Url\Entity\UrlRepository;
//use App\Auth\Service\Tokenizer;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UrlRepository::class => static function (ContainerInterface $container): UrlRepository {
        $em = $container->get(EntityManagerInterface::class);
        $repo = $em->getRepository(Url::class);
        return new UrlRepository($em, $repo);
    }
];
