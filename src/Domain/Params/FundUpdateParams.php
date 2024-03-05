<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Params;

class FundUpdateParams
{
    public ?string $name;
    public ?int $startYear;
    public ?int $managerId;

    /** @var string[]|null */
    public ?array $aliases;

    public function __construct(
        public readonly int $id
    ) {}
}