<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GDTI;

dataset('get_valid_values', fn (): array => [
    ['4719512002889 1234567890 123456'], // valid GTIN13 + valid random optional serial number
    ['4719512002889-1234567890-123456'], // hyphens are OK (dash)
    ['4719512002889 1234567890 123456'], // hyphens are OK (space)
]);

dataset('get_invalid_values', fn (): array => [
    ['0000000000000 1234567890 123456'], // string containing 13 zeros + valid random optional serial number
    ['471951200288-1234567890-123456'], // not 13 chars found in GTIN13 component
    ['4719512002881234567890123456'], // same, but integer
    ['4719512002888-1234567890-123456'], // bad checksum digit
    ['4719512002889.1234567890.123456'],  // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $actual = GDTI::createFromString($value);

    expect($actual->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GDTI::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
