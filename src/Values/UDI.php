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

final class UDI extends Data implements \Stringable, Castable
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
        /** @var string $valueStripped */
        $valueStripped = Str::replace(['‐', '-', ' '], '', $value);
        $valueStrippedLength = \mb_strlen($valueStripped);

        if (!\in_array($valueStrippedLength, [8, 12, 13, 14], true)) {
            throw new \InvalidArgumentException('Invalid UDI: '.$value);
        }

        if (Luhn::check($valueStripped, $valueStrippedLength)) {
            return new self($value);
        }

        throw new \InvalidArgumentException('Invalid UDI: '.$value);
    }

    #[\Override()]
    public static function dataCastUsing(...$arguments): Cast
    {
        return new class() implements Cast
        {
            public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
            {
                return UDI::createFromString((string) $value);
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
