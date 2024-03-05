<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Infra\Repositories;

use Amauri\CanoeAssessment\Domain\Params\FundManagerFindParams;
use Amauri\CanoeAssessment\Domain\Entities\FundManager;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundManagerRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class FundManagerRepository implements FundManagerRepositoryInterface
{
    public function __construct(private readonly Connection $connection) {}

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function find(FundManagerFindParams $params): array
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('*')
            ->from('fund_manager');

        if (isset($params->names) && $params->names) {
            $query->where($query->expr()->in('name', $params->names));
        }

        return array_map(
            function ($row) {
                return FundManager::fromArray($row);
            },
            $query->fetchAllAssociative()
        );
    }
}