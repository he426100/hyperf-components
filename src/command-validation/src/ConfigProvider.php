<?php

declare(strict_types=1);
/**
 * This file is part of friendsofhyperf/components.
 *
 * @link     https://github.com/friendsofhyperf/components
 * @document https://github.com/friendsofhyperf/components/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */

namespace FriendsOfHyperf\CommandValidation;

use FriendsOfHyperf\CommandValidation\Aspect\ValidationAspect;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'aspects' => [
                ValidationAspect::class,
            ],
        ];
    }
}
