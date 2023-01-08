<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Tests\Unit\Event;

use Ghostwriter\ComposerLocker\Event\Lock;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Ghostwriter\ComposerLocker\Event\Lock
 *
 * @internal
 *
 * @small
 */
final class LockTest extends TestCase
{
    /**
     * @covers \Ghostwriter\ComposerLocker\Event\Lock::__construct
     * @covers \Ghostwriter\ComposerLocker\Event\Lock::getBranch
     * @covers \Ghostwriter\ComposerLocker\Event\Lock::getCurrentWorkingDirectory
     */
    public function testConstruct(): void
    {
        $lock = new Lock(
            'branch',
            'path',
        );
        self::assertSame('branch', $lock->getBranch());
        self::assertSame('path', $lock->getCurrentWorkingDirectory());
    }
}
