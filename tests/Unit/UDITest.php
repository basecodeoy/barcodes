<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Barcodes\Values\UDI;

dataset('get_valid_values', fn (): array => [
    ['07610221010301'],  // https://accessgudid.nlm.nih.gov/devices/07610221010301
    ['10887488125541'],  // https://accessgudid.nlm.nih.gov/devices/10887488125541
    ['00868866000011'],  // https://accessgudid.nlm.nih.gov/devices/00868866000011
    ['1038178 0064596'], // https://accessgudid.nlm.nih.gov/devices/10381780064596
]);

dataset('get_invalid_values', fn (): array => [
    ['0000000000000'],   // string containing 13 zeros
    ['10381780064595'],  // bad checksum digit
    ['1038178006459'],   // not 13 chars found
    ['0761022101030'],   // not 13 chars found (string)
    ['0761022101030A'],  // not numeric-only
    ['1038178.0064596'], // dot hyphens are not OK.
]);

it('creates from valid string', function (string $value): void {
    $udi = UDI::createFromString($value);

    expect($udi->toString())->toEqual($value);
})->with('get_valid_values');

it('fails to create from invalid string', function (string $value): void {
    UDI::createFromString($value);
})->throws(InvalidArgumentException::class)->with('get_invalid_values');
