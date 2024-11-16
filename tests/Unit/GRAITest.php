<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GRAI;

dataset('get_valid_values', fn (): array => [
    ['04719512002889 1234567890 12345A'], // valid GTIN13 + valid random optional alphanum serial number
    ['04719512002889-1234567890-123456'], // hyphens are OK (dash)
    ['04719512002889 1234567890 123456'], // hyphens are OK (space)
    ['012345678900051234AX01'], // 50 litre aluminium beer keg + valid random optional alphanum serial number
    ['012345678900051234AX02'], // 50 litre aluminium beer keg + valid random optional alphanum serial number
    ['012345678900051234AX02'], // 50 litre aluminium beer keg + valid random optional alphanum serial number
]);

dataset('get_invalid_values', fn (): array => [
    ['0000000000000 1234567890 12345A'], // 13 zeros + valid random optional alphanum serial number
    ['4719512002881234567890123456'], // same, but integer
    ['04719512002888-1234567890-123456'], // bad checksum digit
    ['04719512002889.1234567890.123456'], // dot hyphens are not OK.
    ['0471951200288-1234567890-12345;'], // invalid non-alphanum serial number
]);

it('creates from valid string', function (string $value): void {
    $actual = GRAI::createFromString($value);

    expect($actual->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GRAI::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
