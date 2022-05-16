<?php

declare(strict_types=1);

use Doctrine\Common\EventManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;

use function App\env;

//Symfony\Component\VarDumper\VarDumper::dump($app); exit;

return [
    EntityManagerInterface::class => static function (ContainerInterface $container): EntityManagerInterface {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     metadata_dirs:array,
         *     dev_mode:bool,
         *     proxy_dir:string,
         *     cache_dir:?string,
         *     types:array<string,class-string<Doctrine\DBAL\Types\Type>>,
         *     subscribers:string[],
         *     connection:array<string, mixed>
         * } $settings
         */
        $settings = $container->get('config')['doctrine'];
        
        $config = Setup::createConfiguration(
            $settings['dev_mode'],
            $settings['proxy_dir'],
            $settings['cache_dir'] ?
                DoctrineProvider::wrap(new FilesystemAdapter('', 0, $settings['cache_dir'])) :
                DoctrineProvider::wrap(new ArrayAdapter())
        );

        $config->setMetadataDriverImpl(new AttributeDriver($settings['metadata_dirs']));
        
        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }

        $eventManager = new EventManager();

        foreach ($settings['subscribers'] as $name) {
            /** @var EventSubscriber $subscriber */
            $subscriber = $container->get($name);
            $eventManager->addEventSubscriber($subscriber);
        }

        return EntityManager::create(
            $settings['connection'],
            $config,
            $eventManager
        );
    },
            
    Connection::class => static function (ContainerInterface $container): Connection {
        $em = $container->get(EntityManagerInterface::class);
        return $em->getConnection();
    },

    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' => __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../../var/cache/doctrine/proxy',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => env('DB_HOST'),
                'user' => env('DB_USER'),
                'password' => env('DB_PASSWORD'),
                'dbname' => env('DB_NAME'),
                'charset' => 'utf-8',
            ],
            'subscribers' => [],
            'metadata_dirs' => [
                __DIR__ . '/../../src/Url/Entity',
            ],
            'types' => [
                App\Url\Entity\InetType::NAME => App\Url\Entity\InetType::class
            ],
        ],
    ],
];
