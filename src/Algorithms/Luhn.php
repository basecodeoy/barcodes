<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Barcodes\Algorithms;

use Spatie\Regex\Regex;

/**
 * @see https://en.wikipedia.org/wiki/Luhn_algorithm
 */
final readonly class Luhn
{
    public static function check(mixed $value, int $length, int $divisor = 10, int $multiplier = 3): bool
    {
        if (!\is_string($value)) {
            $value = (string) $value;
        }

        if (\mb_strlen($value) !== $length) {
            return false;
        }

        if (!Regex::match(\sprintf('/\\d{%d}/i', $length), $value)->hasMatch()) {
            return false;
        }

        if ((int) $value === 0) {
            return false;
        }

        $sum = 0;

        for ($i = 0; $i < $length; $i += 2) {
            if (0 === $length % 2) {
                $sum += $multiplier * (int) \mb_substr($value, $i, 1);
                $sum += (int) \mb_substr($value, $i + 1, 1);
            } else {
                $sum += (int) \mb_substr($value, $i, 1);
                $sum += $multiplier * (int) \mb_substr($value, $i + 1, 1);
            }
        }

        return 0 === $sum % $divisor;
    }
}
