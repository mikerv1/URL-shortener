<?php

declare(strict_types=1);

namespace App\Url\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use App\Url\Entity\Ip;
use App\Url\Entity\Url;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'user_info', schema: 'public')]
final class UserInfo
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id;
 
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $receiveDate;
    
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $requestDate;
    
    
    //must be #[ORM\Embedded(class: Info::class)]
    //private Info $ip;
    #[ORM\Column(type: 'user_ip', nullable: false)]
    private string $userIp;
    
    #[ORM\ManyToOne(targetEntity: Url::class, inversedBy: 'usersInfo')]
    #[ORM\JoinColumn(name: 'url_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Url $url;
    
//    public function __construct(string $ref, string $dataUser, string $userIp)
    
    public function __construct(Url $url, Info $info)
        {
        
        $this->url = $url;
        $this->receiveDate = $info->receiveDate;
        $this->requestDate = $info->requestDate;
        $this->userIp = $info->ip->getValue();
    }
    
    public function getUserIp(): Ip
    {
        return new Ip($this->userIp);
    }
}
