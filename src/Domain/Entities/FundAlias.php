<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Entities;

class FundAlias
{
    public function __construct(
        public readonly int $fundId,
        public readonly string $name
    ) {}

    public static function fromArray(array $raw): self
    {
        return new self($raw['fund_id'], $raw['name']);
    }
}