<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\GSRN;

dataset('get_valid_values', fn (): array => [
    ['735005385000000011'],
    ['735005385 00000001 1'],
    ['735005385-00000001-1'],
]);

dataset('get_invalid_values', fn (): array => [
    ['73500538500000001'], // not 18 chars found
    ['735005385-000000001-1'], // too long
    ['735005385-A0000001-1'], // not numeric-only
    ['735005385-00000001-2'], // bad checksum digit
    ['735005385-00000001.1'], // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $gsrn = GSRN::createFromString($value);

    expect($gsrn->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    GSRN::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
