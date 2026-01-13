<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale\Tests\Model;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WebDevelovers\CodiceFiscale\Model\TaxIDData;

#[CoversClass(TaxIDData::class)]
class TaxIDDataTest extends TestCase
{
    public function testValidDataCreation(): void
    {
        $data = new TaxIDData(
            'Mario',
            'Rossi',
            new DateTime('1990-01-01'),
            'M',
            'H501',
        );

        $this->assertSame('Mario', $data->firstName);
        $this->assertSame('M', $data->gender);
    }

    public function testThrowsExceptionForFutureBirthDate(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Birthdate in the future');

        new TaxIDData(
            'Mario',
            'Rossi',
            new DateTime('tomorrow'),
            'M',
            'H501',
        );
    }

    public function testThrowsExceptionForInvalidGender(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported gender value');

        new TaxIDData(
            'Mario',
            'Rossi',
            new DateTime('1990-01-01'),
            'X',
            'H501',
        );
    }

    public function testThrowsExceptionForInvalidBelfioreLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Belfiore code must be exactly 4 characters');

        new TaxIDData(
            'Mario',
            'Rossi',
            new DateTime('1990-01-01'),
            'M',
            'LETEST',
        );
    }
}
