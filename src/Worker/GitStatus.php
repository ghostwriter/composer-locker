<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker;

use Ghostwriter\ComposerLocker\Contract\Worker;
use Ghostwriter\ComposerLocker\Event\Lock;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Ghostwriter\ComposerLocker\Worker\Traits\WorkerTrait;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GitStatus implements Worker
{
    use WorkerTrait;

    private const COMMAND = ['git', 'status', '-s'];

    public function __construct(
        private readonly ProcessRunner $processRunner,
        private readonly SymfonyStyle $symfonyStyle,
    ) {
    }

    public function work(Lock $lock): void
    {
        $this->symfonyStyle->success($this->processRunner->run(self::COMMAND));
    }
}
