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

    public const COMMIT_MESSAGE = 'Lock file maintenance';

    public const FEATURE_BRANCH = 'chore/composer-locker';

    public const PUSH = ['git', 'push', '--force-with-lease'];

    public const SIGNATURE = 'Signed-off-by: Nathanael Esayeas <nathanael.esayeas@protonmail.com>';

    public const TARGET_BRANCH = 'main';
}
