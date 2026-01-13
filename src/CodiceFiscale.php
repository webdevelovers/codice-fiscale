<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale;

use CodiceFiscale\Calculator;
use CodiceFiscale\Checker;
use CodiceFiscale\InverseCalculator;
use CodiceFiscale\Validator;
use Throwable;
use WebDevelovers\CodiceFiscale\Exception\TaxIDCalculatorException;
use WebDevelovers\CodiceFiscale\Model\InverseData;
use WebDevelovers\CodiceFiscale\Model\TaxIDData;

class CodiceFiscale
{
    public const string PERSON_TAX_ID_REGEX = '/^[A-Za-z]{6}\d{2}[A-Za-z]\d{2}[A-Za-z]\d{3}[A-Za-z]$/';
    public const string COMPANY_TAX_ID_REGEX = '/^(IT)?\d{11}$/';

    /** @throws TaxIDCalculatorException */
    public static function calculate(TaxIDData $taxIDData): string
    {
        try {
            $calculator = new Calculator($taxIDData->toSubject());

            return $calculator->calculate();
        } catch (Throwable $exception) {
            throw new TaxIDCalculatorException('Error calculating tax ID', 0, $exception);
        }
    }

    /** @throws TaxIDCalculatorException */
    public static function inverseCalculation(string $taxID): InverseData
    {
        if (! self::validateFormat($taxID)) {
            throw new TaxIDCalculatorException('Invalid tax ID format: ' . $taxID);
        }

        try {
            $inverseCalculator = new InverseCalculator($taxID);
            $subject = $inverseCalculator->getSubject();

            return InverseData::fromSubject($subject);
        } catch (Throwable $exception) {
            throw new TaxIDCalculatorException(
                $exception->getMessage(),
                (int) $exception->getCode(),
                $exception,
            );
        }
    }

    /**
     * @return string[]
     *
     * @throws TaxIDCalculatorException
     */
    public static function calculateAllPossibilities(TaxIDData $taxIDData): array
    {
        try {
            $calculator = new Calculator($taxIDData->toSubject());

            return $calculator->calculateAllPossibilities();
        } catch (Throwable $exception) {
            throw new TaxIDCalculatorException('Error calculating omocodia possibilities', 0, $exception);
        }
    }

    public static function validateFormat(string $taxID): bool
    {
        $validator = new Validator($taxID);

        return $validator->isFormallyValid();
    }

    /** @throws TaxIDCalculatorException */
    public static function validateData(TaxIDData $taxIDData, string $taxID): bool
    {
        try {
            $checker = new Checker($taxIDData->toSubject(), [
                'codiceFiscaleToCheck' => $taxID,
                'omocodiaLevel' => Checker::ALL_OMOCODIA_LEVELS,
            ]);

            return $checker->check();
        } catch (Throwable $exception) {
            throw new TaxIDCalculatorException('Error validating tax ID data', 0, $exception);
        }
    }
}
