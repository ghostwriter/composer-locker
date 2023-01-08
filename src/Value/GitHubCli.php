<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Value;

final class GitHubCli
{
    public const CREATE_PULL_REQUEST = [
        'gh',
        'pr',
        'create',
        '--head',
        Git::FEATURE_BRANCH,
        '--base',
        Git::TARGET_BRANCH,
        '--fill',
    ];
    public const MERGE_PULL_REQUEST = ['gh', 'pr', 'merge', '--merge', '--delete-branch'];
}
