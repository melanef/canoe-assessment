<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Entities;

class FundManager
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}

    public static function fromArray(array $raw): self
    {
        return new self($raw['id'], $raw['name']);
    }
}