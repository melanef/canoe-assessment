<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Params;

class FundFindParams
{
    public ?string $name;

    public ?int $startYear;

    /** @var int[]|null */
    public ?array $managerIds;

    /** @var int[]|null */
    public ?array $fundIds;
}