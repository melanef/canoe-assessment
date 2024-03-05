<?php

namespace Amauri\CanoeAssessment\Domain\EventBus\Listeners;

use Amauri\CanoeAssessment\Domain\EventBus\Event;

interface ListenerInterface
{
    public function __invoke(Event $event): void;
}