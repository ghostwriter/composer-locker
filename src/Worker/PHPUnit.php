<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker;

use Ghostwriter\ComposerLocker\Contract\Worker;
use Ghostwriter\ComposerLocker\Event\Lock;
use Ghostwriter\ComposerLocker\Worker\Traits\WorkerTrait;

final class PHPUnit implements Worker
{
    use WorkerTrait {
        work as protected traitWork;
    }

    private const COMMAND = ['phpunit', '--colors=always', '--testdox', '--stop-on-failure'];

    public function command(): array
    {
        return self::COMMAND;
    }

    public function work(Lock $lock): void
    {
        $currentWorkingDirectory = $lock->getCurrentWorkingDirectory();

        if (! file_exists($currentWorkingDirectory . '/phpunit.xml')) {
            return;
        }

        if (! file_exists($currentWorkingDirectory . '/phpunit.xml.dist')) {
            return;
        }

        $this->traitWork($lock);
    }
}
