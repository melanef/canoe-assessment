<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Entities;

class Company
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
}