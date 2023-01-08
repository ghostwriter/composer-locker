<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker\Traits;

use Ghostwriter\ComposerLocker\Event\Lock;

trait WorkerTrait
{
    public function description(Lock $lock): string
    {
        return sprintf(
            'Running %s on "%s" branch; in "%s".',
            basename(self::class),
            $lock->getBranch(),
            $lock->getCurrentWorkingDirectory()
        );
    }

    public function work(Lock $lock): void
    {
        $this->symfonyStyle->success($this->processRunner->run(['echo', self::class]));
    }
}
