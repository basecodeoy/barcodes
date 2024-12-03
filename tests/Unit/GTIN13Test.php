<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GTIN13;

dataset('get_valid_values', fn (): array => [
    ['4006381333931'],
    ['5901234123457'],
    ['9780201379624'],
    ['9310779300005'],
]);

dataset('get_invalid_values', fn (): array => [
    ['4006381333932'], // incorrect check digit
    ['4601234567890'], // incorrect check digit
    ['5901234123456'], // incorrect check digit
    ['1234567890123'], // arbitrary number, incorrect check digit
]);

it('creates from valid string', function (string $value): void {
    $gtin13 = GTIN13::createFromString($value);

    expect($gtin13->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GTIN13::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
