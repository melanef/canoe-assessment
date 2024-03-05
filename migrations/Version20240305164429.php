<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305164429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial empty DB';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE TABLE fund_manager (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE TABLE fund (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, start_year INT NOT NULL, manager_id INT NOT NULL, PRIMARY KEY (id), INDEX manager_id_index(manager_id), FOREIGN KEY (manager_id) REFERENCES fund_manager(id) ON DELETE CASCADE)');

        $this->addSql('CREATE TABLE fund_alias (fund_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (fund_id, name), INDEX fund_id_index(fund_id), FOREIGN KEY (fund_id) REFERENCES fund(id) ON DELETE CASCADE)');

        $this->addSql('CREATE TABLE fund_company (fund_id INT NOT NULL, company_id INT NOT NULL, PRIMARY KEY (fund_id, company_id), INDEX fund_id_index(fund_id), FOREIGN KEY (fund_id) REFERENCES fund(id) ON DELETE CASCADE, INDEX company_id_index(company_id), FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE fund_manager');
        $this->addSql('DROP TABLE fund');
        $this->addSql('DROP TABLE fund_alias');
        $this->addSql('DROP TABLE fund_company');
    }
}
