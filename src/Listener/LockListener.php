<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Listener;

use Ghostwriter\ComposerLocker\Contract\Worker;
use Ghostwriter\ComposerLocker\Event\Lock;
use Ghostwriter\ComposerLocker\Worker\ComposerUpdate;
use Ghostwriter\ComposerLocker\Worker\ComposerValidate;
use Ghostwriter\ComposerLocker\Worker\GitAddAll;
use Ghostwriter\ComposerLocker\Worker\GitCheckoutNewBranch;
use Ghostwriter\ComposerLocker\Worker\GitCommit;
use Ghostwriter\ComposerLocker\Worker\GitHubCliCreatePullRequest;
use Ghostwriter\ComposerLocker\Worker\GitHubCliMergePullRequest;
use Ghostwriter\ComposerLocker\Worker\GitPush;
use Ghostwriter\ComposerLocker\Worker\GitStatus;
use Ghostwriter\ComposerLocker\Worker\PHPUnit;
use Ghostwriter\Container\Container;
use Symfony\Component\Console\Style\SymfonyStyle;

final class LockListener
{
    /**
     * @var array<class-string<Worker>>
     */
    private const TASKS = [
        GitStatus::class,
        GitCheckoutNewBranch::class,
        PHPUnit::class,
        ComposerValidate::class,
        ComposerUpdate::class,
        PHPUnit::class,
        GitStatus::class, // this will stop the rest of the tasks from running if no update found.
        GitAddAll::class,
        GitCommit::class,
        GitPush::class,
        GitHubCliCreatePullRequest::class,
        GitHubCliMergePullRequest::class,
        PHPUnit::class,
    ];

    public function __construct(
        private readonly Container $container,
        private readonly SymfonyStyle $symfonyStyle
    ) {
    }

    public function __invoke(Lock $lock): void
    {
        $this->symfonyStyle->warning(
            sprintf(
                'Locking "%s" branch in "%s" directory.',
                $lock->getBranch(),
                $lock->getCurrentWorkingDirectory(),
            )
        );

        array_map(function (mixed $task) use ($lock): string {
            /** @var class-string<Worker> $task */
            $worker = $this->container->get($task);

            $worker->work($lock);

            return $task;
        }, self::TASKS);
    }
}
