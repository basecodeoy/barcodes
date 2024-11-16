<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Barcodes\Values;

use BaseCodeOy\Barcodes\Algorithms\Luhn;
use Illuminate\Support\Str;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Castable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

final class GDTI extends Data implements \Stringable, Castable
{
    public function __construct(
        public readonly string $value,
    ) {}

    #[\Override()]
    public function __toString(): string
    {
        return $this->value;
    }

    public static function createFromString(string $value): self
    {
        if (\mb_strlen($value) < 13) {
            throw new \InvalidArgumentException('Invalid GDTI: '.$value);
        }

        /** @var string $valueStripped */
        $valueStripped = Str::replace(['‐', '-', ' '], '', $value);

        if (\mb_strlen($valueStripped) > 30) {
            throw new \InvalidArgumentException('Invalid GDTI: '.$value);
        }

        if (Luhn::check(\mb_substr($valueStripped, 0, 13), 13)) {
            return new self($value);
        }

        throw new \InvalidArgumentException('Invalid GDTI: '.$value);
    }

    #[\Override()]
    public static function dataCastUsing(...$arguments): Cast
    {
        return new class() implements Cast
        {
            public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
            {
                return GDTI::createFromString((string) $value);
            }
        };
    }

    public function isEqualTo(self $other): bool
    {
        return $this->value === $other->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
