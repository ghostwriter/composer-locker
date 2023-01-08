<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Value;

final class GitHubCli
{
    public const COMMIT = 'Bump composer dependencies';

    public const HEAD_BRANCH = Git::HEAD_BRANCH;

    public const SIGNATURE = 'Signed-off-by: Nathanael Esayeas <nathanael.esayeas@protonmail.com>';

    public const TITLE = 'Lock file maintenance';
}
