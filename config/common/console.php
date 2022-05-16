<?php

declare(strict_types=1);

//use App\OAuth;
use Doctrine\Migrations;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;


//use App\Console\FixturesLoadCommand;
//use App\OAuth\Console\E2ETokenCommand;
//use Doctrine\Migrations;
//use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool;
//use Psr\Container\ContainerInterface;

return [
    'config' => [
        'console' => [
            'commands' => [
                ValidateSchemaCommand::class,
                Migrations\Tools\Console\Command\ExecuteCommand::class,
                Migrations\Tools\Console\Command\MigrateCommand::class,
                Migrations\Tools\Console\Command\LatestCommand::class,
                Migrations\Tools\Console\Command\ListCommand::class,
                Migrations\Tools\Console\Command\StatusCommand::class,
                Migrations\Tools\Console\Command\UpToDateCommand::class,
                SchemaTool\DropCommand::class,
                SchemaTool\CreateCommand::class,
            ],
        ],
    ],
];
