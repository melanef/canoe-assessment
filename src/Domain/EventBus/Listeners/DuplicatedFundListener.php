<?php

namespace Amauri\CanoeAssessment\Domain\EventBus\Listeners;

use Amauri\CanoeAssessment\Domain\Entities\Fund;
use Amauri\CanoeAssessment\Domain\EventBus\Event;
use Amauri\CanoeAssessment\Domain\EventBus\EventBusInterface;
use Amauri\CanoeAssessment\Domain\Params\FundFindParams;
use Amauri\CanoeAssessment\Domain\Services\FundAliasService;
use Amauri\CanoeAssessment\Domain\Services\FundService;

class DuplicatedFundListener implements ListenerInterface
{
    public function __construct(
        private readonly FundService $fundService,
        private readonly FundAliasService $fundAliasService,
        private readonly EventBusInterface $eventBus
    ) {}

    public function __invoke(Event $event): void
    {
        $newFund = Fund::fromArray((array) $event->metadata);

        $params = new FundFindParams();
        $params->name = $newFund->name;
        $params->managerIds = [$newFund->managerId];

        $found = $this->fundService->find($params);
        foreach ($found as $fund) {
            if ($fund->id !== $newFund->id) {
                continue;
            }

            $this->eventBus->handle(new Event('duplicate_fund_warning', $event->metadata));
            return;
        }

        $params = new FundFindParams();
        $params->managerIds = [$newFund->managerId];
        $params->fundIds = $this->fundAliasService->findByName($newFund->name);

        if (empty($params->fundIds)) {
            return;
        }

        $found = $this->fundService->find($params);
        foreach ($found as $fund) {
            if ($fund->id !== $newFund->id) {
                continue;
            }

            $this->eventBus->handle(new Event('duplicate_fund_warning', $event->metadata));
            return;
        }
    }
}