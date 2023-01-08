<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\EventDispatcher\Contract\ErrorEventInterface;
use Ghostwriter\EventDispatcher\Contract\EventInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class Dump
{
    public function __construct(
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    public function __invoke(EventInterface $event): void
    {
        $this->symfonyStyle->section('[DEBUG]: ' . $event::class);
        if ($event instanceof ErrorEventInterface) {
            $this->symfonyStyle->error('Error: ' . $event->getThrowable()->getMessage());
            die;
        }
    }
}
