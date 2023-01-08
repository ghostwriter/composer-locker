<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Event\ComposerBump;
use Ghostwriter\ComposerLocker\Event\ComposerTest;
use Ghostwriter\ComposerLocker\Event\ComposerUpdate;
use Ghostwriter\ComposerLocker\Event\ComposerValidate;
use Ghostwriter\ComposerLocker\Event\GitCheckoutNewBranch;
use Ghostwriter\ComposerLocker\Event\GitCommit;
use Ghostwriter\ComposerLocker\Event\GitHubCliCreatePullRequest;
use Ghostwriter\ComposerLocker\Event\GitHubCliMergePullRequest;
use Ghostwriter\ComposerLocker\Event\GitPush;
use Ghostwriter\ComposerLocker\Event\GitStatus;
use Ghostwriter\ComposerLocker\Event\Lock;
use Ghostwriter\Container\Container;
use Ghostwriter\EventDispatcher\Contract\EventInterface;
use Ghostwriter\EventDispatcher\Dispatcher;
use Symfony\Component\Console\Style\SymfonyStyle;

final class LockListener
{
    /**
     * @var class-string<EventInterface>[]
     */
    private array $tasks = [
        GitStatus::class,
        GitCheckoutNewBranch::class,
        ComposerTest::class,
        ComposerUpdate::class,
        ComposerBump::class,
        ComposerValidate::class,
        ComposerTest::class,
        //        GitStatus::class,
        GitCommit::class,
        GitPush::class,
        GitHubCliCreatePullRequest::class,
        GitHubCliMergePullRequest::class,
    ];

    public function __construct(
        private Container $container,
        private Dispatcher $dispatcher,
        private SymfonyStyle $symfonyStyle
    ) {
    }

    public function __invoke(Lock $event): void
    {
        $this->symfonyStyle->warning(
            sprintf(
                'Locking "%s" branch in "%s" directory.',
                $event->getBranch(),
                $event->getCurrentWorkingDirectory(),
            )
        );
        array_map(
            fn (string $task): EventInterface
            => $this->dispatcher->dispatch($this->container->build($task)),
            $this->tasks
        );
    }
}
