<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker;

use Ghostwriter\ComposerLocker\Contract\Worker;
use Ghostwriter\ComposerLocker\Value\Composer;
use Ghostwriter\ComposerLocker\Worker\Traits\WorkerTrait;

final class ComposerUpdate implements Worker
{
    use WorkerTrait;

    public function command(): array
    {
        return Composer::UPDATE;
    }
}
