<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Faker\Factory;
use Faker\Generator;
use Psr\Log\LoggerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305172721 extends AbstractMigration
{
    private Generator $faker;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        parent::__construct($connection, $logger);

        $this->faker = Factory::create();
    }

    public function getDescription(): string
    {
        return 'Test data seeds';
    }

    public function up(Schema $schema): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->addSql(sprintf(
                'INSERT INTO fund_manager SET name = "%s"',
                $this->faker->company()
            ));
        }

        for ($i = 0; $i < 10; $i++) {
            $this->addSql(sprintf(
                'INSERT INTO fund SET name = "%s", start_year = %d, manager_id = %d',
                $this->faker->words(2, true),
                $this->faker->year(),
                $this->faker->numberBetween(1, 3)
            ));
        }

        for ($i = 0; $i < 50; $i++) {
            $this->addSql(sprintf(
                'INSERT INTO fund_alias SET fund_id = %d, name = "%s"',
                $this->faker->numberBetween(1, 10),
                $this->faker->words(2, true)
            ));
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE fund_alias');
        $this->addSql('TRUNCATE fund');
        $this->addSql('TRUNCATE fund_manager');
    }
}
