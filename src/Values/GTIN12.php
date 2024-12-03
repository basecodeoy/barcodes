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

final class GTIN12 extends Data implements \Stringable, Castable
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

        if (\mb_strlen($valueStripped) !== 12) {
            throw new \InvalidArgumentException('Invalid GTIN-12: '.$value);
        }

        if (Luhn::check($valueStripped, 12)) {
            return new self($value);
        }

        throw new \InvalidArgumentException('Invalid GTIN-12: '.$value);
    }

    #[\Override()]
    public static function dataCastUsing(...$arguments): Cast
    {
        return new class() implements Cast
        {
            public function cast(DataProperty $dataProperty, mixed $value, array $properties, CreationContext $creationContext): mixed
            {
                return GTIN12::createFromString((string) $value);
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
