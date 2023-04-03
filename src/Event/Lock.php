<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Event;

use Ghostwriter\EventDispatcher\Contract\EventInterface;
use Ghostwriter\EventDispatcher\Traits\EventTrait;

/** @implements EventInterface<false> */
final class Lock implements EventInterface
{
    use EventTrait;

    public function __construct(
        private readonly string $branch,
        private readonly string $cwd,
    ) {
    }

    public function getBranch(): string
    {
        return $this->branch;
    }

    public function getCurrentWorkingDirectory(): string
    {
        return $this->cwd;
    }
}
