<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker\Traits;

use Ghostwriter\ComposerLocker\Event\Lock;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;

trait WorkerTrait
{
    public function __construct(
        private readonly ProcessRunner $processRunner,
        private readonly SymfonyStyle $symfonyStyle,
    ) {
    }

    public function command(): array
    {
        return ['echo', self::class];
    }

    public function description(Lock $lock): string
    {
        return sprintf(
            'Running [%s] on [%s] branch; in [%s].',
            mb_substr(mb_strrchr(self::class, '\\'), 1),
            $lock->getBranch(),
            $lock->getCurrentWorkingDirectory()
        );
    }

    public function work(Lock $lock): void
    {
        $this->symfonyStyle->warning($this->description($lock));

        $this->symfonyStyle->success(
            $this->processRunner->run($this->command(), $lock->getCurrentWorkingDirectory())
        );
    }
}
