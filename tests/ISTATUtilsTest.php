<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WebDevelovers\CodiceFiscale\ISTATUtils;
use WebDevelovers\CodiceFiscale\Model\ISTATCity;

use function strtoupper;

#[CoversClass(ISTATUtils::class)]
class ISTATUtilsTest extends TestCase
{
    public function testFindCityByBelfioreCode(): void
    {
        $city = ISTATUtils::findCityByField('codiceCatastaleComune', 'H501');

        $this->assertInstanceOf(ISTATCity::class, $city);
        $this->assertSame('ROMA', strtoupper($city->denominazioneItaliano));
        $this->assertSame('RM', $city->siglaAutomobilistica);
    }

    public function testFindCityByName(): void
    {
        $city = ISTATUtils::findCityByName('Roma');

        $this->assertInstanceOf(ISTATCity::class, $city);
        $this->assertSame('H501', $city->codiceCatastaleComune);
    }

    public function testReturnsNullForNonExistentCity(): void
    {
        $city = ISTATUtils::findCityByField('codiceCatastaleComune', 'XXXX');
        $this->assertNull($city);
    }
}
