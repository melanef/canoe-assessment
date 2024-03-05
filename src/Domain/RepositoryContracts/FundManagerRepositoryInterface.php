<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\RepositoryContracts;

use Amauri\CanoeAssessment\Domain\Params\FundManagerFindParams;
use Amauri\CanoeAssessment\Domain\Entities\FundManager;

interface FundManagerRepositoryInterface
{
    /** @return FundManager[] */
    public function find(FundManagerFindParams $params): array;
}