<?php

declare(strict_types=1);

namespace App\Url\Query\FindDataByHash;

use Doctrine\DBAL\Connection;

final class Fetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(string $hash)
    {
        $result = $this->connection->createQueryBuilder()
            ->select('u.hash')
            ->addSelect('ui.user_ip', 'ui.receive_date', 'ui.request_date')
            ->from('url', 'u')
            ->join('u', 'user_info', 'ui', 'u.id = ui.url_id')
            ->where('hash = :hash')
            ->setParameter('hash', $hash)
            ->executeQuery();
        
        return $result->fetchAllAssociative();
    }
}
