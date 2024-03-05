<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\RepositoryContracts;

use Amauri\CanoeAssessment\Domain\Params\FundCreateParams;
use Amauri\CanoeAssessment\Domain\Params\FundFindParams;
use Amauri\CanoeAssessment\Domain\Entities\Fund;
use Amauri\CanoeAssessment\Domain\Params\FundUpdateParams;

interface FundRepositoryInterface
{
    /** @return Fund[] */
    public function find(FundFindParams $params): array;

    public function findOneById(int $id): Fund;

    public function create(FundCreateParams $params): Fund;

    public function update(FundUpdateParams $params): Fund;
}