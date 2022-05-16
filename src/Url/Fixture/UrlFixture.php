<?php

declare(strict_types=1);

namespace App\Url\Fixture;

//use App\Auth\Entity\User\Email;
//use App\Auth\Entity\User\Id;
//use App\Auth\Entity\User\Token;
use App\Url\Entity\Url;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use App\Url\Entity\Info;
use App\Url\Entity\Ip;
//use Ramsey\Uuid\Uuid;

final class UrlFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $url = Url::createUrl(
            new DateTimeImmutable('now'),
            'https://www.example.com/page?utm_content=buffercf3b2&utm_medium=social&utm_source=facebook.com&utm_campaign=buffer',
            '8a85c312',
            new DateTimeImmutable('-30 days'),
            'google',
            'cpc',
            'spring_sale',
            'running+shoes',
            'textlink',
            new Info('It is ref', new DateTimeImmutable('now'), new Ip('31.41.120.84'))
        );
        
        $url->attachInfo(new info('It is ref2', new DateTimeImmutable('now'), new Ip('32.41.120.84')));
        
//        $url = Url::createUrl(
//            $creationDate = new DateTimeImmutable('now'),
//            $originalUrl = 'https://www.example.com/page?utm_content=buffercf3b2&utm_medium=social&utm_source=facebook.com&utm_campaign=buffer',
//            $newUrl = 'http://localhost:8080/deRty123',
//            $expirationDate = new DateTimeImmutable('-30 days'),
//            $utmSource = 'google',
//            $utmMedium = 'cpc',
//            $utmCampaing = 'spring_sale',
//            $utmTerm = 'running+shoes',
//            $utmContent = 'textlink',
//            new Info($ref = 'It is ref', $dataUser = 'It is dataUser', $userIp = '127.0.0.0.1')
//        );

//        $url->confirmJoin($value, $date);

        $manager->persist($url);

        $manager->flush();
    }
}
