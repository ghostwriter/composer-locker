<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker;

use Ghostwriter\ComposerLocker\Contract\Worker;
use Ghostwriter\ComposerLocker\Value\Git;
use Ghostwriter\ComposerLocker\Worker\Traits\WorkerTrait;

final class GitPush implements Worker
{
    use WorkerTrait;

    public function command(): array
    {
        return Git::PUSH;
    }
}
