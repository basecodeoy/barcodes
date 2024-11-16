<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GLN;

dataset('get_valid_values', fn (): array => [
    ['0614141000012'], // Checked using http://www.gs1.org/check-digit-calculator
    ['0614141000029'], // Checked using http://www.gs1.org/check-digit-calculator
    ['0614141000036'], // Checked using http://www.gs1.org/check-digit-calculator
    ['0614141 00002 9'], // hyphens are OK (space)
    ['0614141-00003-6'], // hyphens are OK (dash)
]);

dataset('get_invalid_values', fn (): array => [
    ['0000000000000'], // string containing 13 zeros
    ['061414100001'], // not 13 chars found
    ['061414100001'], // not 13 chars found
    ['A614141000016'], // not numeric-only
    ['0614141000015'], // bad checksum digit
    ['0614141.00001.6'], // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $actual = GLN::createFromString($value);

    expect($actual->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GLN::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
