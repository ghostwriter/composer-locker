<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Process;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use function trim;

final class ProcessRunner
{
    public function __construct(
        private SymfonyStyle $symfonyStyle
    ) {
    }

    /**
     * @param array<string> $command
     */
    public function run(array $command, ?string $cwd = null): string
    {
        $this->symfonyStyle->note(sprintf('Running command: "%s"', implode(' ', $command)));

        return trim($this->createProcess($command, $cwd ?? getcwd())->setTimeout(null)->mustRun()->getOutput());
    }

    private function createProcess(array $command, string $cwd): Process
    {
        return new Process($command, $cwd);
    }
}
