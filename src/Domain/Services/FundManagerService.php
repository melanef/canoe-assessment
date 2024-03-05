<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Services;

use Amauri\CanoeAssessment\Domain\Params\FundManagerFindParams;
use Amauri\CanoeAssessment\Domain\Entities\FundManager;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundManagerRepositoryInterface;

class FundManagerService
{
    public function __construct(private readonly FundManagerRepositoryInterface $repository) {}

    /** @return FundManager[] */
    public function find(FundManagerFindParams $context): array
    {
        return $this->repository->find($context);
    }
}