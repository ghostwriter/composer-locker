<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Event\GitHubCliCreatePullRequest;
use Ghostwriter\ComposerLocker\Event\GitHubCliMergePullRequest;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GitHubCliMergePullRequestListener
{
    private const COMMAND = ['echo','"gh pr merge"'];
    // gh pr create --base "main" -f && gh pr merge --merge --delete-branch

    public function __construct(
        private ProcessRunner $processRunner,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function __invoke(GitHubCliMergePullRequest $event): void
    {
        $this->symfonyStyle->success($this->processRunner->run(self::COMMAND));
    }
}
