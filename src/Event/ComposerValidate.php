<?php

declare(strict_types=1);

namespace Ghostwriter\ComposerLocker\Event;

use Ghostwriter\EventDispatcher\Contract\EventInterface;
use Ghostwriter\EventDispatcher\Traits\EventTrait;

final class ComposerValidate implements EventInterface
{
    use EventTrait;
}
