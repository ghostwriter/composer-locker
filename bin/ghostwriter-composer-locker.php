#!/usr/bin/env php
<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker;

use Ghostwriter\ComposerLocker\Event\Lock;
use Ghostwriter\ComposerLocker\Listener\Dump;
use Ghostwriter\ComposerLocker\Value\Git;
use Ghostwriter\Container\Container;
use Ghostwriter\Container\Contract\ContainerInterface;
use Ghostwriter\EventDispatcher\Contract\DispatcherInterface;
use Ghostwriter\EventDispatcher\Contract\EventInterface;
use Ghostwriter\EventDispatcher\Contract\ListenerProviderInterface;
use Ghostwriter\EventDispatcher\Dispatcher;
use Ghostwriter\EventDispatcher\ListenerProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use function dirname;
use function sprintf;

/** @var ?string $_composer_autoload_path */
(static function (string $composerAutoloadPath): void {
    /** @psalm-suppress UnresolvableInclude */
    require $composerAutoloadPath ?: fwrite(
        STDERR,
        sprintf('[ERROR]Cannot locate "%s"\n please run "composer install"\n', $composerAutoloadPath)
    ) && exit(1);

    /**
     * #BlackLivesMatter.
     */

    $container = Container::getInstance();

    $container->bind(ListenerProvider::class);
    $container->alias(ListenerProviderInterface::class, ListenerProvider::class);
    $container->set(
        Dispatcher::class,
        static fn (ContainerInterface $container): Dispatcher => $container->build(
            Dispatcher::class,
            [
                'listenerProvider' => $container->get(ListenerProviderInterface::class),
            ]
        )
    );
    $container->alias(DispatcherInterface::class, Dispatcher::class);

    // Input
    $container->bind(ArgvInput::class);
    $container->bind(ArrayInput::class);
    $container->bind(StringInput::class);
    $container->alias(Input::class, ArgvInput::class);
    $container->alias(InputInterface::class, Input::class);
    // Output
    $container->bind(ConsoleOutput::class);
    $container->bind(NullOutput::class);
    $container->bind(SymfonyStyle::class);
    $container->alias(Output::class, ConsoleOutput::class);
    $container->alias(OutputInterface::class, Output::class);
    $container->alias(OutputFormatterInterface::class, OutputFormatter::class);

    $container->extend(
        ListenerProvider::class,
        static function (ContainerInterface $container, ListenerProvider $listenerProvider): ListenerProvider {
            $listenerProvider->bindListener(EventInterface::class, Dump::class);

            foreach ($container->build(Finder::class)
                ->files()
                ->in(dirname(__DIR__) . '/src/Listener/')
                ->name('*Listener.php')
                ->sortByName()
                ->getIterator() as $splFileInfo) {
                /** @var class-string<\Ghostwriter\EventDispatcher\Contract\EventInterface<bool> $event */
                $event = sprintf('%s\Event\%s', __NAMESPACE__, $splFileInfo->getBasename('Listener.php'));

                /** @var class-string $listener */
                $listener =  sprintf("%s\Listener\%s", __NAMESPACE__, $splFileInfo->getBasename('.php'));
                $listenerProvider->bindListener($event, $listener);
            }

            return $listenerProvider;
        }
    );

    $container->build(SingleCommandApplication::class)
        ->setName('ghostwriter/composer-locker - #BlackLivesMatter✊🏾')
        ->setVersion('1.0.0')
        ->setDescription('Update composer.json and composer.lock files, then commit changes if tests pass.')
        ->addArgument('branch', InputArgument::OPTIONAL, 'Branch to work on.', Git::TARGET_BRANCH)
        ->addOption(
            'path',
            'p',
            InputOption::VALUE_OPTIONAL,
            'Path to the project root where composer.json and composer.lock files are located.',
            getcwd()
        )
        ->setCode(
            static fn (
                InputInterface $input,
                OutputInterface $output
            ): int => $container->get(Dispatcher::class)
                ->dispatch(
                    $container->build(
                        Lock::class,
                        [
                            'branch' => $input->getArgument('branch'),
                            'cwd' => $input->getOption('path'),
                        ]
                    )
                )
                ->isPropagationStopped() ?
                Command::FAILURE :
                Command::SUCCESS
        )
        ->run();
})($_composer_autoload_path ?? dirname(__DIR__) . '/vendor/autoload.php');
