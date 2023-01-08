<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Event\GitHubCliCreatePullRequest;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GitHubCliCreatePullRequestListener
{
    private const COMMAND = ['echo', '"gh pr"'];
    // gh pr create --base "main" -f && gh pr merge --merge --delete-branch

    public function __construct(
        private ProcessRunner $processRunner,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function __invoke(GitHubCliCreatePullRequest $event): void
    {
        $this->symfonyStyle->success($this->processRunner->run(self::COMMAND));
    }
}
