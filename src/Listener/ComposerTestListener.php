<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Event\ComposerTest;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ComposerTestListener
{
    private const COMMAND = ['vendor/bin/phpunit'];

    public function __construct(
        private ProcessRunner $processRunner,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function __invoke(ComposerTest $event): void
    {
        $this->symfonyStyle->success($this->processRunner->run(self::COMMAND));
    }
}
