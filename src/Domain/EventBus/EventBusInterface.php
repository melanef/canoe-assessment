<?php

namespace Amauri\CanoeAssessment\Domain\EventBus;

interface EventBusInterface
{
    public function handle(Event $event): void;
}