<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

arch('globals')
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();

// arch('BaseCodeOy\Values\Values')
//     ->expect('BaseCodeOy\Values\Values')
//     ->toUseStrictTypes()
//     ->toBeFinal()
//     ->ignoring('BaseCodeOy\Values\Values\Algorithms')
//     ->ignoring('BaseCodeOy\Values\Values\Exceptions');

// arch('BaseCodeOy\Values\Values\Algorithms')
//     ->expect('BaseCodeOy\Values\Values\Algorithms')
//     ->toUseStrictTypes()
//     ->toBeFinal()
//     ->toBeReadonly();

// arch('BaseCodeOy\Values\Values\Exceptions')
//     ->expect('BaseCodeOy\Values\Values\Exceptions')
//     ->toUseStrictTypes()
//     ->toBeFinal()
//     ->toHaveSuffix('Exception')
//     ->toExtend('InvalidArgumentException');
