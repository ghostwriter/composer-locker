<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker;

use Ghostwriter\ComposerLocker\Contract\Worker;
use Ghostwriter\ComposerLocker\Event\Lock;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Ghostwriter\ComposerLocker\Value\Composer;
use Ghostwriter\ComposerLocker\Worker\Traits\WorkerTrait;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ComposerValidate implements Worker
{
    use WorkerTrait;

    public function __construct(
        private ProcessRunner $processRunner,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function work(Lock $lock): void
    {
        $this->symfonyStyle->success($this->processRunner->run(Composer::VALIDATE));
    }
}
