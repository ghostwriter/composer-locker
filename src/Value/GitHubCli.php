<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Value;

final class GitHubCli
{
    public const BASE = Git::TARGET_BRANCH;

    public const BODY = 'Bump composer dependencies' . PHP_EOL . PHP_EOL . self::SIGNATURE;

    public const CREATE_PULL_REQUEST = [
        'gh',
        'pr',
        'create',
        '--head',
        self::HEAD,
        '--base',
        self::BASE,
        '--body',
        self::BODY,
        '--title',
        self::TITLE,
        '--fill',
    ];

    public const HEAD = Git::HEAD_BRANCH;

    public const MERGE_PULL_REQUEST = ['gh', 'pr', 'merge', '--merge', '--delete-branch'];

    public const SIGNATURE = 'Signed-off-by: Nathanael Esayeas <nathanael.esayeas@protonmail.com>';

    public const TITLE = 'Lock file maintenance';
}
