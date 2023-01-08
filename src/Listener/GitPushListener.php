<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Event\GitPush;
use Ghostwriter\ComposerLocker\Event\GitStatus;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GitPushListener
{
    private const COMMAND = ['git', 'push', '--all'];

    public function __construct(
        private ProcessRunner $processRunner,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function __invoke(GitPush $event): void
    {
        $this->symfonyStyle->warning(sprintf('Running command: "%s"', implode(' ', self::COMMAND)));

        if (false){
            $this->symfonyStyle->success($this->processRunner->run(self::COMMAND));
        }

    }
}
