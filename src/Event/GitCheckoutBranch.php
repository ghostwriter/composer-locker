<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Event;

use Ghostwriter\EventDispatcher\Contract\EventInterface;
use Ghostwriter\EventDispatcher\Traits\EventTrait;

final class GitCheckoutBranch implements EventInterface
{
    use EventTrait;

    public function __construct(
        private string $branch = 'main',
    ) {
    }

    public function getBranch(): string
    {
        return $this->branch;
    }
}
