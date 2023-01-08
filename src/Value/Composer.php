<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Value;

final class Composer
{
    public const UPDATE = [
        'composer',
        'update',
        '--no-interaction',
        '--no-plugins',
        '--no-scripts',
        '--no-suggest',
    ];

    public const VALIDATE = [
        'composer',
        'validate',
        '--check-lock',
        '--no-interaction',
        '--no-plugins',
        '--no-scripts',
        '--strict',
    ];
}
