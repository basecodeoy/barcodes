<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GTIN12;

dataset('get_valid_values', fn (): array => [
    ['614141000036'], // http://www.gs1.org/barcodes/ean-upc
    ['1-23456-78999-9'], // https://en.wikipedia.org/wiki/Universal_Product_Code
]);

dataset('get_invalid_values', fn (): array => [
    ['000000000000'], // string containing all zeros
    ['614141000037'], // bad checksum digit
    ['61414100003'], // not 13 chars found
    ['61414100003'], // not 13 chars found
    ['A14141000036'], // not numeric-only
    ['1.23456.78999.9'], // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $actual = GTIN12::createFromString($value);

    expect($actual->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GTIN12::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
