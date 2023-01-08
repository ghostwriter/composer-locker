<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Value;

final class Git
{
    public const CHECKOUT_BRANCH = ['git', 'switch', self::HEAD_BRANCH];

    public const CHECKOUT_NEW_BRANCH = ['git', 'switch', '-c', self::HEAD_BRANCH];

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

    public const HEAD_BRANCH = 'chore/composer-locker';

    public const TARGET_BRANCH = 'main';
}
