<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Event\ComposerBump;
use Ghostwriter\ComposerLocker\Process\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ComposerBumpListener
{
    private const COMMAND = ['composer', 'bump', '--no-scripts', '--no-plugins'];

    public function __construct(
        private ProcessRunner $processRunner,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function __invoke(ComposerBump $event): void
    {
        $this->symfonyStyle->success($this->processRunner->run(self::COMMAND));
    }
}
