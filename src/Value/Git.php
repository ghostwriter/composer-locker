<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Value;

final class Git
{
    public const ADD_ALL = ['git', 'add', '--all'];

    public const CHECKOUT_NEW_BRANCH = ['git', 'checkout', '-B', self::FEATURE_BRANCH, self::TARGET_BRANCH];

    public const COMMIT = [
        'git',
        'commit',
        '--cleanup',
        'strip',
        '--signoff',
        '--gpg-sign',
        '--message',
        self::COMMIT_MESSAGE,
    ];

    public const COMMIT_MESSAGE = 'Bump composer dependencies';

    public const FEATURE_BRANCH = 'chore/composer-locker';

    public const TARGET_BRANCH = 'main';
}
