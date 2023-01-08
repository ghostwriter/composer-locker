<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Event\GitCheckoutBranch;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GitCheckoutBranchListener
{
    private const COMMAND = ['git', 'switch', 'chore/composer-locker'];

    public function __construct(
        private ProcessRunner $processRunner,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function __invoke(GitCheckoutBranch $event): void
    {
        $this->symfonyStyle->success($this->processRunner->run(self::COMMAND));
    }
}
