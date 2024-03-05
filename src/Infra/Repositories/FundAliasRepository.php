<?php

namespace Amauri\CanoeAssessment\Infra\Repositories;

use Amauri\CanoeAssessment\Domain\Entities\FundAlias;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundAliasRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class FundAliasRepository implements FundAliasRepositoryInterface
{
    public function __construct(private readonly Connection $connection) {}

    public function findByFundIds(array $fundIds): array
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('*')
            ->from('fund_alias')
            ->where($query->expr()->in('fund_id', $fundIds));

        return array_map(
            function ($row) {
                return FundAlias::fromArray($row);
            },
            $query->fetchAllAssociative()
        );
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function findByFundId(int $fundId): array
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('*')
            ->from('fund_alias')
            ->where('fund_id = :fund_id')
            ->setParameter('fund_id', $fundId);

        return array_map(
            function ($row) {
                return FundAlias::fromArray($row);
            },
            $query->fetchAllAssociative()
        );
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function findByName(string $name): array
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('*')
            ->from('fund_alias')
            ->where('name = :name')
            ->setParameter('name', $name);

        return array_map(
            function ($row) {
                return FundAlias::fromArray($row);
            },
            $query->fetchAllAssociative()
        );
    }

    /**
     * @throws Exception
     */
    public function delete(int $fundId, string $name): void
    {
        $query = $this->connection->createQueryBuilder();

        $query->delete('fund_alias')
            ->where('fund_id = :fund_id')
            ->andWhere('name = :name')
            ->setParameter('fund_id', $fundId)
            ->setParameter('name', $name);

        $query->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function create(int $fundId, string $name): void
    {
        $query = $this->connection->createQueryBuilder();

        $query->insert('fund_alias')
            ->values([
                'name' => ':name',
                'fund_id' => ':fund_id',
            ])
            ->setParameter('name', $name)
            ->setParameter('fund_id', $fundId);

        $query->executeStatement();
    }
}