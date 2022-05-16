<?php

declare(strict_types=1);

namespace App\Url\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;
use DomainException;
//use Doctrine

use App\Url\Entity\UserInfo;
//use App\Url\Entity\Utm;

#[ORM\Entity]
#[Index(name: 'hash_idx', columns: ['hash'])]
//#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'url', schema: 'public')]
final class Url
{
//    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
//    #[ORM\Id]
//    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
//    #[ORM\SequenceGenerator(sequenceName: 'schema.seq_url_id', allocationSize: 1, initialValue: 1)]
//    private int $id;
    
    #[ORM\Column(type: 'integer')]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id;
    
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $creationDate;
    
    #[ORM\Column(type: 'string', nullable: false)]
    private string $originalUrl;
    
    #[ORM\Column(type: 'string', nullable: false, unique: true)]
    private string $hash;
    
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $expirationDate;
    
    #[ORM\OneToMany(mappedBy: 'url', targetEntity: UserInfo::class, cascade: ['all'], orphanRemoval: true)]
    private Collection $usersInfo;
  
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $utmSource;
    
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $utmMedium;
    
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $utmCampaing;
    
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $utmTerm;
    
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $utmContent;
    
    private function __construct(DateTimeImmutable $creationDate,
        string $originalUrl,
        string $hash, 
        DateTimeImmutable $expirationDate
        )
    {
        $this->creationDate = $creationDate;
        $this->originalUrl = $originalUrl;
        $this->hash = $hash;
        $this->expirationDate = $expirationDate;
        $this->usersInfo = new ArrayCollection();
    }
    
    public static function createUrl(
        DateTimeImmutable $creationDate,
        string $originalUrl,
        string $hash,
        DateTimeImmutable $expirationDate,
        ?string $utmSource,
        ?string $utmMedium,
        ?string $utmCampaing,
        ?string $utmTerm,
        ?string $utmContent,
        Info $info
    ): self {
        $url = new self($creationDate, $originalUrl, $hash, $expirationDate);
        $url->utmSource = $utmSource;
        $url->utmMedium = $utmMedium;
        $url->utmCampaing = $utmCampaing;
        $url->utmTerm = $utmTerm;
        $url->utmContent = $utmContent;
        $url->usersInfo->add(new UserInfo($url, $info));
        return $url;
    }
    
    public function attachInfo(Info $info): void
    {
        $this->usersInfo->add(new UserInfo($this, $info));
    }
    
    public function getHash(): ?string
    {
        return $this->hash;
    }
    
    public function getUrl(): ?string
    {
        return $this->originalUrl;
    }
}
