<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Infra\Repositories;

use Amauri\CanoeAssessment\Domain\Params\FundCreateParams;
use Amauri\CanoeAssessment\Domain\Params\FundFindParams;
use Amauri\CanoeAssessment\Domain\Entities\Fund;
use Amauri\CanoeAssessment\Domain\Params\FundUpdateParams;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundRepositoryInterface;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class FundRepository implements FundRepositoryInterface
{
    public function __construct(private readonly Connection $connection) {}

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function find(FundFindParams $params): array
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('*')
            ->from('fund');

        if (isset($params->fundIds) && $params->fundIds) {
            $query->where($query->expr()->in('id', $params->fundIds));
        }

        if (isset($params->name) && $params->name) {
            $query->where('name = :name')
                ->setParameter('name', $params->name);
        }

        if (isset($params->startYear) && $params->startYear) {
            $query->where('start_year = :start_year')
                ->setParameter('start_year', $params->startYear);
        }

        if (isset($params->managerIds) && $params->managerIds) {
            $query->where($query->expr()->in('manager_id', $params->managerIds));
        }

        return array_map(
            function ($row) {
                return Fund::fromArray($row);
            },
            $query->fetchAllAssociative()
        );
    }

    public function findOneById(int $id): Fund
    {
        $query = $this->connection->createQueryBuilder();

        $raw = $query->select('*')
            ->from('fund')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        return Fund::fromArray($raw);
    }

    public function create(FundCreateParams $params): Fund
    {
        $query = $this->connection->createQueryBuilder();

        $query->insert('fund')
            ->values([
                'name' => ':name',
                'start_year' => ':start_year',
                'manager_id' => ':manager_id',
            ])
            ->setParameter('name', $params->name)
            ->setParameter('start_year', (new DateTimeImmutable())->format('Y'))
            ->setParameter('manager_id', (string) $params->managerId);

        $query->executeStatement();

        return $this->findOneById((int) $this->connection->lastInsertId());
    }

    public function update(FundUpdateParams $params): Fund
    {
        $query = $this->connection->createQueryBuilder();

        $query->update('fund')
            ->where('id = :id')
            ->setParameter('id', $params->id);

        if (isset($params->name) && $params->name) {
            $query->set('name', ':name')
                ->setParameter('name', $params->name);
        }

        if (isset($params->startYear) && $params->startYear) {
            $query->set('start_year', ':start_year')
                ->setParameter('start_year', (string) $params->startYear);
        }

        if (isset($params->managerId) && $params->managerId) {
            $query->set('manager_id', ':manager_id')
                ->setParameter('manager_id', (string) $params->managerId);
        }

        $query->executeStatement();

        return $this->findOneById($params->id);
    }
}