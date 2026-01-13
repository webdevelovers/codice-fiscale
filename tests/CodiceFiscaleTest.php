<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale\Tests;

use DateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WebDevelovers\CodiceFiscale\CodiceFiscale;
use WebDevelovers\CodiceFiscale\Model\TaxIDData;

use function strtoupper;

#[CoversClass(CodiceFiscale::class)]
class CodiceFiscaleTest extends TestCase
{
    public function testCalculateCorrectTaxID(): void
    {
        $data = new TaxIDData(
            'Mario',
            'Rossi',
            new DateTime('1980-01-01'),
            'M',
            'H501',
        );

        $cf = CodiceFiscale::calculate($data);
        $this->assertSame('RSSMRA80A01H501U', strtoupper($cf));
    }

    public function testInverseCalculationReturnsISTATData(): void
    {
        $cf = 'RSSMRA80A01H501U';
        $inverse = CodiceFiscale::inverseCalculation($cf);

        $this->assertSame('M', $inverse->gender);
        $this->assertSame('H501', $inverse->belfioreCode);
        $this->assertNotNull($inverse->istatData);
        $this->assertSame('ROMA', strtoupper($inverse->istatData->denominazioneItaliano));
    }

    public function testValidateFormat(): void
    {
        $this->assertTrue(CodiceFiscale::validateFormat('RSSMRA80A01H501U'));
        $this->assertFalse(CodiceFiscale::validateFormat('INVALID-CF'));
    }

    public function testValidateData(): void
    {
        $data = new TaxIDData(
            'Mario',
            'Rossi',
            new DateTime('1980-01-01'),
            'M',
            'H501',
        );

        $this->assertTrue(CodiceFiscale::validateData($data, 'RSSMRA80A01H501U'));
    }
}
