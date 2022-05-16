<?php

declare(strict_types=1);

namespace App\Url\Query\FindUrlByHash;

use App\Url\Command\RequestUrl\Request\Command;
//use App\Url\Entity\Status;
//use App\Auth\Service\PasswordHasher;
use Doctrine\DBAL\Connection;

final class Fetcher
{
    private Connection $connection;
//    private PasswordHasher $hasher;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
//        $this->hasher = $hasher;
    }

    public function fetch(Command $command): ?Url
    {
        $result = $this->connection->createQueryBuilder()
            ->select([
                'id',
//                'status',
                'hash',
            ])
            ->from('url')
            ->where('hash = :hash')
            ->setParameter('hash', $command->hash)
            ->executeQuery();
        
//        $result = $this->connection->createQueryBuilder('u')
//            ->select('u', 'ui')
////            ->from('url', 'u')
//            ->join('user_info', 'ui', 'with', 'u.id = ui.url_id')
//            ->where('user_ip = :user_ip')
//            ->setParameter('user_ip', $command->ip)
//            ->executeQuery();
//        
        
        /**
         * @var array{
         *     id: string,
         *     status: string,
         *     password_hash: ?string,
         * }|false
         */
        $row = $result->fetchAssociative();

        if ($row === false) {
            return null;
        }

        $hash = $row['hash'];

        if ($hash === null) {
            return null;
        }

//        if (!$this->hasher->validate($query->password, $hash)) {
//            return null;
//        }

        return new Url(
            id: $row['id'],
//            ip: $row['user_ip'],
            hash: $row['hash']
        );
    }
}
