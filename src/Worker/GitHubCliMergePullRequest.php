<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Worker;

use Ghostwriter\ComposerLocker\Contract\Worker;
use Ghostwriter\ComposerLocker\Value\GitHubCli;
use Ghostwriter\ComposerLocker\Worker\Traits\WorkerTrait;

final class GitHubCliMergePullRequest implements Worker
{
    use WorkerTrait;

    public function command(): array
    {
        return GitHubCli::MERGE_PULL_REQUEST;
    }
}
