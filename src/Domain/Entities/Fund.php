<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Entities;

use DateTimeImmutable;
use DateTimeInterface;

class Fund
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly int    $startYear,
        public readonly int    $managerId,
        public readonly array  $aliases,
    ) {}

    public static function fromArray(array $raw): self
    {
        return new self(
            $raw['id'],
            $raw['name'],
            $raw['start_year'],
            $raw['manager_id'],
            array_key_exists('aliases', $raw) ? $raw['aliases'] : []
        );
    }

    public function withAliases(array $aliases): self
    {
        return new self(
            $this->id,
            $this->name,
            $this->startYear,
            $this->managerId,
            $aliases
        );
    }
}