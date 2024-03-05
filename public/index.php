<?php

use Amauri\CanoeAssessment\Domain\EventBus\EventBusInterface;
use Amauri\CanoeAssessment\Domain\EventBus\Listeners\DuplicatedFundListener;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundAliasRepositoryInterface;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundManagerRepositoryInterface;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundRepositoryInterface;
use Amauri\CanoeAssessment\Infra\EventBus\RealTimeEventBus;
use Amauri\CanoeAssessment\Infra\Repositories\FundAliasRepository;
use Amauri\CanoeAssessment\Infra\Repositories\FundManagerRepository;
use Amauri\CanoeAssessment\Infra\Repositories\FundRepository;
use Amauri\CanoeAssessment\Infra\Web\Controllers\FundController;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$app = Bridge::create(
    new Container([
        Connection::class => DriverManager::getConnection([
            'dbname' => $_ENV['MYSQL_DATABASE'],
            'user' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD'],
            'host' => $_ENV['MYSQL_HOST'],
            'driver' => 'pdo_mysql',
        ]),
        FundRepositoryInterface::class => DI\autowire(FundRepository::class),
        FundManagerRepositoryInterface::class => DI\autowire(FundManagerRepository::class),
        FundAliasRepositoryInterface::class => DI\autowire(FundAliasRepository::class),
        EventBusInterface::class => new RealTimeEventBus([]),
    ])
);

$app->get('/funds', [FundController::class, 'find']);
$app->post('/funds/', [FundController::class, 'create']);
$app->post('/funds/{id}', [FundController::class, 'update']);

$app->run();
