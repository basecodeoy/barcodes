<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GTIN14;

dataset('get_valid_values', fn (): array => [
    ['12345678901231'],
    ['00012345600012'], // http://www.gtin.info/
]);

dataset('get_invalid_values', fn (): array => [
    ['00000000000000'], // string containing all zeros
    ['12345678901232'], // bad checksum digit
    ['1234567890123'], // not 13 chars found
    ['1234567890123'], // not 13 chars found
    ['A1234567890123'], // not numeric-only
    ['12345.67890.1231'], // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $actual = GTIN14::createFromString($value);

    expect($actual->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GTIN14::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
