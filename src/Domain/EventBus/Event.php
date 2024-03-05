<?php

namespace Amauri\CanoeAssessment\Domain\EventBus;

class Event
{
    public function __construct(
        public readonly string $event,
        public readonly object $metadata
    ) {}
}