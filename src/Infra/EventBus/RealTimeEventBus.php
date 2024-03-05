<?php

namespace Amauri\CanoeAssessment\Infra\EventBus;

use Amauri\CanoeAssessment\Domain\EventBus\Event;
use Amauri\CanoeAssessment\Domain\EventBus\EventBusInterface;

class RealTimeEventBus implements EventBusInterface
{
    public function __construct(
        /** @var callable[][] */
        private readonly array $listeners
    ) {}

    public function handle(Event $event): void
    {
        if (!array_key_exists($event->event, $this->listeners)) {
            return;
        }

        foreach ($this->listeners[$event->event] as $listener) {
            $listener($event);
        }
    }
}