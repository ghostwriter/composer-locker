<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Contract;

use Ghostwriter\ComposerLocker\Event\Lock;

interface Worker
{
    public function description(Lock $lock): string;

    public function work(Lock $lock): void;
}
