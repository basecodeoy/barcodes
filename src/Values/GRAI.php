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

final class GRAI extends Data implements \Stringable, Castable
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
            throw new \InvalidArgumentException('Invalid GRAI: '.$value);
        }

        /** @var string $valueStripped */
        $valueStripped = Str::replace(['‐', '-', ' '], '', $value);

        if (0 !== (int) $valueStripped[0]) {
            throw new \InvalidArgumentException('Invalid GRAI: '.$value);
        }

        $valueStripped = \mb_substr($valueStripped, 1, \mb_strlen($valueStripped) - 1);

        if (\mb_strlen($valueStripped) > 29) {
            throw new \InvalidArgumentException('Invalid GRAI: '.$value);
        }

        if (!\ctype_alnum(\mb_substr($valueStripped, 13, \mb_strlen($valueStripped)))) {
            throw new \InvalidArgumentException('Invalid GRAI: '.$value);
        }

        if (Luhn::check(\mb_substr($valueStripped, 0, 13), 13)) {
            return new self($value);
        }

        throw new \InvalidArgumentException('Invalid GRAI: '.$value);
    }

    #[\Override()]
    public static function dataCastUsing(...$arguments): Cast
    {
        return new class() implements Cast
        {
            public function cast(DataProperty $dataProperty, mixed $value, array $properties, CreationContext $creationContext): mixed
            {
                return GRAI::createFromString((string) $value);
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
