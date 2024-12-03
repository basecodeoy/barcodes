<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GTIN8;

dataset('get_valid_values', fn (): array => [
    ['42345671'], // vi.Wikipedia
    ['4719-5127'], // fr.Wikipedia
    ['9638-5074'], // en.Wikipedia
]);

dataset('get_invalid_values', fn (): array => [
    ['00000000'], // string containing all zeros
    ['42345670'], // bad checksum digit
    ['423456712'], // not 8 chars found
    ['423456712'], // not 8 chars found
    ['12345671'], // not numeric-only
    ['4234.5671'], // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $gtin8 = GTIN8::createFromString($value);

    expect($gtin8->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GTIN8::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
