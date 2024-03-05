<?php

namespace Amauri\CanoeAssessment\Domain\Services;

use Amauri\CanoeAssessment\Domain\Params\FundCreateParams;
use Amauri\CanoeAssessment\Domain\Params\FundUpdateParams;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundAliasRepositoryInterface;

class FundAliasService
{
    public function __construct(private readonly FundAliasRepositoryInterface $repository) {}

    public function create(int $id, FundCreateParams $params): void
    {
        foreach ($params->aliases as $alias) {
            $this->repository->create($id, $alias);
        }
    }

    public function update(FundUpdateParams $params): void
    {
        $aliasesToKeep = $params->aliases;
        $storedAliases = $this->findByFundId($params->id);

        $aliasesToDelete = array_filter(
            $storedAliases,
            function ($alias) use ($aliasesToKeep) {
                return !in_array($alias, $aliasesToKeep);
            }
        );
        $aliasesToInsert = array_filter(
            $aliasesToKeep,
            function ($alias) use ($storedAliases) {
                return !in_array($alias, $storedAliases);
            }
        );

        foreach ($aliasesToDelete as $alias) {
            $this->repository->delete($params->id, $alias);
        }

        foreach ($aliasesToInsert as $alias) {
            $this->repository->create($params->id, $alias);
        }
    }

    public function findByName(string $name): array
    {
        return array_map(
            function ($item) {
                return $item->fundId;
            },
            $this->repository->findByName($name)
        );
    }

    public function findByFundId(int $fundId): array
    {
        return array_map(
            function ($item) {
                return $item->name;
            },
            $this->repository->findByFundId($fundId)
        );
    }

    public function findByFundIds(array $fundIds): array
    {
        $grouped = [];
        $aliases = $this->repository->findByFundIds($fundIds);
        foreach ($aliases as $alias) {
            if (!array_key_exists($alias->fundId, $grouped)) {
                $grouped[$alias->fundId] = [];
            }

            $grouped[$alias->fundId][] = $alias->name;
        }

        return $grouped;
    }
}