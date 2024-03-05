<?php

namespace Amauri\CanoeAssessment\Domain\RepositoryContracts;

use Amauri\CanoeAssessment\Domain\Entities\FundAlias;

interface FundAliasRepositoryInterface
{
    /** @return FundAlias[] */
    public function findByFundIds(array $fundIds): array;

    /** @return FundAlias[] */
    public function findByFundId(int $fundId): array;

    /** @return FundAlias[] */
    public function findByName(string $name): array;

    public function delete(int $fundId, string $name): void;

    public function create(int $fundId, string $name): void;
}