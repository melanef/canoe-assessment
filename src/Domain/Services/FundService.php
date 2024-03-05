<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Services;

use Amauri\CanoeAssessment\Domain\Entities\Fund;
use Amauri\CanoeAssessment\Domain\EventBus\Event;
use Amauri\CanoeAssessment\Domain\EventBus\EventBusInterface;
use Amauri\CanoeAssessment\Domain\Params\FundCreateParams;
use Amauri\CanoeAssessment\Domain\Params\FundFindParams;
use Amauri\CanoeAssessment\Domain\Params\FundUpdateParams;
use Amauri\CanoeAssessment\Domain\RepositoryContracts\FundRepositoryInterface;

class FundService
{
    public function __construct(
        private readonly FundRepositoryInterface $repository,
        private readonly FundAliasService $aliasService,
        private readonly EventBusInterface $eventBus
    ) {}

    /** @return Fund[] */
    public function find(FundFindParams $params): array
    {
        $funds = $this->repository->find($params);
        $fundIds = array_map(
            function ($fund) {
                return $fund->id;
            },
            $funds
        );

        $aliases = $this->aliasService->findByFundIds($fundIds);
        foreach ($funds as $i => $fund) {
            $funds[$i] = $fund->withAliases($aliases[$fund->id]);
        }

        return $funds;
    }

    public function findOneById(int $id): Fund
    {
        $fund = $this->repository->findOneById($id);

        return $fund->withAliases($this->aliasService->findByFundId($id));
    }

    public function create(FundCreateParams $params): Fund
    {
        $fund = $this->repository->create($params);
        $this->aliasService->create($fund->id, $params);

        $created = $this->findOneById($fund->id);

        $this->eventBus->handle(new Event('fund_created', $created));

        return $created;
    }

    public function update(FundUpdateParams $params): Fund
    {
        $this->repository->update($params);
        $this->aliasService->update($params);

        return $this->findOneById($params->id);
    }
}