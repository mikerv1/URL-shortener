<?php

declare(strict_types=1);

namespace App\Url\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

final class UrlRepository
{
    /**
     * @var EntityRepository<Url>
     */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    /**
     * @param EntityRepository<Url> $repo
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function getByHash($hash): ?Url
    {
        return $this->repo->findOneBy(['hash' => $hash]);
    }
    
    public function add(Url $url): void
    {
        $this->em->persist($url);
    }
}
