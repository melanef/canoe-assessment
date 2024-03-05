<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Domain\Params;

class FundCreateParams
{
    public string $name;

    public int $managerId;

    /** @var string[]|null */
    public ?array $aliases;
}