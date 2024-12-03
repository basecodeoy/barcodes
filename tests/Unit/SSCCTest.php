<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\SSCC;

dataset('get_valid_values', fn (): array => [
    ['806141411234567896'], // http://www.gs1.org/docs/barcodes/RFID_Barcode_Interoperability_Guidelines.pdf, p.11
    ['007189085627231896'], // http://www.morovia.com/kb/Serial-Shipping-Container-Code-SSCC18-10601.html
    ['054100001234567897'], // https://www.barcoderobot.com/sscc.html
    ['340123450000000000'], // http://www.activebarcode.com/codes/ean18_nve_sscc18.html
]);

dataset('get_invalid_values', fn (): array => [
    ['000000000000000000'], // string containing all zeros
    ['806141411234567897'], // bad checksum digit
    ['8061414112345678961'], // not 13 chars found
    ['8061414112345678961'], // not 13 chars found
    ['A06141411234567896'], // not numeric-only
    ['806141411.2345678961'], // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $sscc = SSCC::createFromString($value);

    expect($sscc->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    SSCC::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
